<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapusat;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PengembalianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_pinjam');
        $tanggalAkhir = $request->input('tanggal_kembali');

        // 🔥 Ambil data peminjaman yang sudah dikembalikan
        $query = Peminjaman::with(['tim', 'datapusat'])
                    ->where('status', 'dikembalikan');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tanggal_kembali', [$tanggalAwal, $tanggalAkhir]);
        }

        $kembali = $query->get();

        // Format tanggal
        foreach ($kembali as $data) {
            $data->formatted_tanggal = Carbon::parse($data->tanggal_kembali)
                ->translatedFormat('l, d F Y');
        }

        // 🔥 Data pengembalian (relasi ke peminjaman)
        $pengembalian = Pengembalian::with([
            'peminjaman.tim',
            'peminjaman.datapusat'
        ])->get();

        return view('pengembalian.index', compact('kembali', 'pengembalian'));
    }

    public function export()
    {
        $data = Datapusat::all();

        $pdf = PDF::loadView('datapusat.datapusat_pdf', ['data' => $data]);
        return $pdf->download('laporan-data-pusat.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

            // ❗ Cegah double return
            if ($peminjaman->status == 'dikembalikan') {
                return redirect()->back()->with('error', 'Barang sudah dikembalikan');
            }

            // 📝 Simpan pengembalian
            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'jumlah_dikembalikan' => $peminjaman->jumlah,
                'tanggal_kembali' => now(),
            ]);

            // 🔄 Update peminjaman
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
            ]);

            // ➕ Kembalikan stok
            $tool = Datapusat::find($peminjaman->id_tool);
            $tool->increment('stok', $peminjaman->jumlah);

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();

        return redirect()->route('pengembalian.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
