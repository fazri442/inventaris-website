<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPusat;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PengembalianController extends Controller
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

    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_pinjam');
        $tanggalAkhir = $request->input('tanggal_kembali');

        if (!$tanggalAwal || !$tanggalAkhir) {
            $kembali = Peminjaman::where('status', 'Sudah Dikembalikan')->get();
        } else {
            $kembali = Peminjaman::where('status', 'Sudah Dikembalikan')
                ->whereBetween('tanggal_kembali', [$tanggalAwal, $tanggalAkhir])
                ->get();
        }

        foreach ($kembali as $data) {
            $data->formatted_tanggal = Carbon::parse($data->tanggal_kembali)->translatedFormat('l, d F Y');
        }
        $peminjam = Peminjaman::with(['pengembalian.datapusat'])  // load peminjaman + tim
                ->get();  // atau query lain sesuai kebutuhan

            // atau kalau view langsung pakai $pinjam dari Peminjaman:
            $pengembalian = Pengembalian::with('datapusat')->where('status', 'Sudah Dikembalikan')->get();
        return view('pengembalian.index', compact('kembali', 'peminjam', 'pengembalian'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peminjaman $pengembalian)
    {
        $pengembalian->delete();
        session()->flash('success', 'Data Berhasil Dihapus');
        return redirect()->route('pengembalian.index');
    }
}
