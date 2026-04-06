<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapusat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPeminjaman;
use App\Models\Tim;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

use RealRashid\SweetAlert\Facades\Alert;

class PeminjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(request $request)
    {
        
        $tanggalAwal = $request->input('tanggal_pinjam');
        $tanggalAkhir = $request->input('tanggal_kembali');

        if (!$tanggalAwal || !$tanggalAkhir) {
            $pinjam = Peminjaman::where('status', 'Sedang Dipinjam')->get();
        } else {
            $pinjam = Peminjaman::where('status', 'Sedang Dipinjam')
                ->whereBetween('tanggal_pinjam', [$tanggalAwal, $tanggalAkhir])
                ->get();
            }

            foreach ($pinjam as $data) {
                $data->formatted_tanggal_pinjam = Carbon::parse($data->tanggal_pinjam)->translatedFormat('l, d F Y');
                $data->formatted_tanggal_kembali = Carbon::parse($data->tanggal_kembali)->translatedFormat('l, d F Y');
            }

            $detail = DetailPeminjaman::all();
            $tim = Tim::all();
            $pengembalian = Pengembalian::with(['peminjaman.pinjam'])  // load peminjaman + tim
                ->get();  // atau query lain sesuai kebutuhan

            // atau kalau view langsung pakai $pinjam dari Peminjaman:
            $pinjam = Peminjaman::with('pinjam')->where('status', 'Sedang Dipinjam')->get();
            return view('peminjam.index', compact('pinjam', 'detail', 'tim', 'pengembalian'));
    }

    public function export()
    {
        
    $data = DataPusat::all();

    $pdf = Pdf::loadView('datapusat.datapusat_pdf', ['data' => $data]);
    return $pdf->download('laporan-data-pusat.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datapusat = Datapusat::where('stok', '>', 0)->get();
        $tim = Tim::all();
        return view('peminjam.create', compact('datapusat', 'tim'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
    $validated = $request->validate([
            'id_tim'    => 'required|exists:tims,id',
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'tools'            => 'required|array|min:1',
            'tools.*.id_tool'  => 'required|exists:datapusats,id|distinct',
            'tools.*.jumlah'   => 'required|integer|min:1',
        ], [
            'tools.required'         => 'Minimal pilih 1 barang',
            'tools.min'              => 'Minimal pilih 1 barang',
            'tools.*.id_tool.exists' => 'Salah satu barang tidak valid',
            'tools.*.jumlah.min'     => 'Jumlah minimal 1',
        ]); // validasi kamu

    try {
        DB::beginTransaction();

        $last = Peminjaman::latest('id')->first();
        $lastId = $last ? $last->id : 0;
        $kode_pinjam = 'PJB-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        // Buat header
        $peminjaman = Peminjaman::create([
            'kode_pinjam'     => $kode_pinjam,
            'id_tim'   => $request->id_tim,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'Sedang Dipinjam',
        ]);

        // Debug setelah insert header
        Log::info('Header peminjaman dibuat', ['id' => $peminjaman->id]);

        foreach ($validated['tools'] as $item) {
            $tool = Datapusat::findOrFail($item['id_tool']);
            $jumlah = (int) $item['jumlah'];

            if ($tool->stok < $jumlah) {
                throw new \Exception("Stok {$tool->nama_tool} tidak cukup. Tersisa: {$tool->stok}");
            }

            // Simpan detail
            $detail = DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id,
                'id_tool'       => $tool->id,
                'jumlah'        => $jumlah,
            ]);

            Log::info('Detail dibuat', ['detail_id' => $detail->id]);

            // Kurangi stok
            $tool->stok -= $jumlah;
            $tool->save();
        }

        DB::commit();

        return redirect()->route('peminjam.index')->with('success', "Peminjaman berhasil! Kode: {$kode_pinjam}");

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal simpan peminjaman: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage() ?: 'Gagal menyimpan peminjaman');
    }
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $peminjaman = Peminjaman::with('detail.tool')->findOrFail($id);  // load detail + tool
    $datapusat = Datapusat::where('stok', '>', 0)->get();  // tool yang ada stok
    $tim = Tim::all();

    // Pre-fill data untuk dynamic row (jika ingin edit detail)
    $existingDetails = $peminjaman->detail->map(function ($detail) {
        return [
            'id_tool' => $detail->id_tool,
            'jumlah' => $detail->jumlah,
            'nama_tool' => $detail->tool->nama_tool ?? 'Unknown',
            'stok' => $detail->tool->stok ?? 0,
        ];
    })->toArray();

    return view('peminjam.edit', compact('peminjaman', 'datapusat', 'tim', 'existingDetails'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'id_tim'    => 'required|exists:tims,id',
        'tanggal_pinjam'   => 'required|date',
        'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
        'status'           => 'required|in:Sedang Dipinjam,Sudah Dikembalikan',
        'tools'            => 'required|array|min:1',
        'tools.*.id_tool'  => 'required|exists:datapusats,id|distinct',
        'tools.*.jumlah'   => 'required|integer|min:1',
    ]);

    try {
        DB::beginTransaction();

        $peminjaman = Peminjaman::with('detail.tool')->findOrFail($id);

        // 1. Handle status kembali (kembalikan stok semua detail lama)
        if ($request->status === 'Sudah Dikembalikan' && $peminjaman->status !== 'Sudah Dikembalikan') {
            foreach ($peminjaman->detail as $detail) {
                $tool = $detail->tool;
                if ($tool) {
                    $tool->stok += $detail->jumlah;
                    $tool->save();
                }
            }
            // Hapus detail lama (opsional, atau biarkan untuk history)
            // $peminjaman->details()->delete();
        }

        // 2. Handle perubahan detail (hanya jika status masih dipinjam)
        if ($request->status === 'Sedang Dipinjam') {
            // Kembalikan stok semua detail lama
            foreach ($peminjaman->detail as $detail) {
                $tool = $detail->tool;
                if ($tool) {
                    $tool->stok += $detail->jumlah;
                    $tool->save();
                }
            }
            $peminjaman->detail()->delete();  // hapus detail lama

            // Tambah detail baru + kurangi stok
            foreach ($validated['tools'] as $item) {
                $tool = Datapusat::findOrFail($item['id_tool']);
                $jumlah = (int) $item['jumlah'];

                if ($tool->stok < $jumlah) {
                    throw new \Exception("Stok {$tool->nama_tool} tidak cukup. Tersisa: {$tool->stok}");
                }

                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id,
                    'id_tool'       => $tool->id,
                    'jumlah'        => $jumlah,
                ]);

                $tool->stok -= $jumlah;
                $tool->save();
            }
        }

        // 3. Update header
        $peminjaman->update([
            'id_tim'   => $request->id_tim,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => $request->status,
        ]);

        DB::commit();

        return redirect()->route('peminjam.index')
            ->with('success', 'Peminjaman berhasil diperbarui');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage() ?: 'Gagal memperbarui peminjaman');
    }
}
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findorfail($id);
        if ($peminjaman->status === 'Sedang Dipinjam') {
            foreach ($peminjaman->detail as $detail) {
                $barang = Datapusat::findOrFail($detail->id_tool);
                $barang->stok += $detail->jumlah;
                $barang->save();
            }
        }
        $peminjaman->delete();
        return redirect()->route('peminjam.index')->with('success', 'Data Berhasil Dihapus');
    }
}
