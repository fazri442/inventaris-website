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
            $peminjaman = Peminjaman::where('status', 'Sedang Dipinjam')->get();
        } else {
            $peminjaman = Peminjaman::where('status', 'Sedang Dipinjam')
                ->whereBetween('tanggal_pinjam', [$tanggalAwal, $tanggalAkhir])
                ->get();
            }

            foreach ($peminjaman as $data) {
                $data->formatted_tanggal_pinjam = Carbon::parse($data->tanggal_pinjam)->translatedFormat('l, d F Y');
                $data->formatted_tanggal_kembali = Carbon::parse($data->tanggal_kembali)->translatedFormat('l, d F Y');
            }

            $tim = Tim::all();
            $pengembalian = Pengembalian::with(['peminjaman'])->get();
            $peminjaman = Peminjaman::with(['tim','datapusat','pengembalian'])->get();
            return view('peminjam.index', compact('tim','pengembalian','peminjaman'));
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
        DB::beginTransaction();
        try {
            $tool = Datapusat::findOrFail($request->id_tool);

            if ($tool->stok < $request->jumlah) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Stok tidak mencukupi');
            }

            $peminjaman = Peminjaman::create([
                'kode_pinjam' => 'PJM-' . time(),
                'id_tim' => $request->id_tim,
                'id_tool' => $request->id_tool,
                'jumlah' => $request->jumlah,
                'tanggal_pinjam' => now(),
                'tanggal_rencana_kembali' => $request->tanggal_rencana_kembali,
                'status' => 'dipinjam',
            ]);

            $tool->decrement('stok', $request->jumlah);

            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
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
        $peminjaman = Peminjaman::with(['tim', 'datapusat'])->findOrFail($id);
        $datapusat = Datapusat::where('stok', '>', 0)->get();
        $tim = Tim::all();
        return view('peminjam.edit', compact('peminjaman','datapusat','tim'));
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
        $request->validate([
            'id_tim' => 'required|exists:tims,id',
            'id_tool' => 'required|exists:datapusats,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_rencana_kembali' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            $toolLama = Datapusat::find($peminjaman->id_tool);
            $toolBaru = Datapusat::find($request->id_tool);

            // 🔁 Kembalikan stok lama
            $toolLama->increment('stok', $peminjaman->jumlah);

            // ❗ Cek stok baru
            if ($toolBaru->stok < $request->jumlah) {
                throw new \Exception("Stok tidak mencukupi");
            }

            // ➖ Kurangi stok baru
            $toolBaru->decrement('stok', $request->jumlah);

            // 🔄 Update data
            $peminjaman->update([
                'id_tim' => $request->id_tim,
                'id_tool' => $request->id_tool,
                'jumlah' => $request->jumlah,
                'tanggal_rencana_kembali' => $request->tanggal_rencana_kembali,
            ]);

            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Data berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
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
