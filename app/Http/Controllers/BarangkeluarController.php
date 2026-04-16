<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangkeluar;
use App\Models\Datapusat;
use App\Models\Tim;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class BarangkeluarController extends Controller
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

    public function index()
    {
        $keluar = Barangkeluar::all();
        $pusat = Datapusat::all();
        return view('keluar.index', compact('keluar', 'pusat'));
    }

    public function export()
    {
        
    $keluar = Barangkeluar::all();
    

    $pdf = Pdf::loadView('keluar.barangkeluar_pdf', ['keluar' => $keluar]);
    return $pdf->download('laporan-data-pengeluaran.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangkeluar = Barangkeluar::all();
        $datapusat = Datapusat::all();
        $tim = Tim::all();
        return view('keluar.create', compact('barangkeluar', 'datapusat', 'tim'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required|string',
            'jumlah' => 'required|integer',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'id_tool' => 'required|exists:datapusats,id',
        ],
        [
            'nama_tim.required' => 'Nama Tim tidak boleh kosong',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'tanggal_keluar.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
            'keterangan.string' => 'Keterangan harus berupa teks',
            'lokasi.string' => 'Lokasi harus berupa teks',
            'id_tool.required' => 'ID Tool tidak boleh kosong',
            'id_tool.exists' => 'ID Tool tidak ditemukan',
        ]);
        $keluar = new Barangkeluar;
        $lastRecord = Barangkeluar::latest('id')->first();
        $lastId = $lastRecord ? $lastRecord->id : 0;
        $kodetool = 'KLR-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        $keluar->kode_tool = $kodetool;

        $pusat = Datapusat::find($request->id_tool);
        if ($pusat->stok < $request->jumlah) {
               return redirect()->back()
                ->withInput()
                ->with('error', 'Stok Dari Gudang Berisi: ' .$pusat->stok);
        }
        $pusat->stok -= $request->jumlah;
        $pusat->save();

        $keluar->jumlah = $request->jumlah;
        $keluar->tanggal_keluar = $request->tanggal_keluar;
        $keluar->keterangan = $request->keterangan;
        $keluar->id_tool = $request->id_tool;
        $keluar->nama_tim = $request->nama_tim;
        $keluar->lokasi = $request->lokasi;

        $keluar->save();
        return redirect()->route('barangkeluar.index')->with('success', 'Data Berhasil Masuk');
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
        $barangkeluar = Barangkeluar::findorfail($id);
        $pusat = Datapusat::all();
        $tim = Tim::all();
        return view('keluar.edit', compact('barangkeluar', 'pusat', 'tim'));
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
            'nama_tim' => 'required|string',
            'jumlah' => 'required|integer',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'id_tool' => 'required|exists:datapusats,id',
        ],
        [
            'nama_tim.required' => 'Nama Tim tidak boleh kosong',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'tanggal_keluar.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
            'keterangan.string' => 'Keterangan harus berupa teks',
            'lokasi.string' => 'Lokasi harus berupa teks',
            'id_tool.required' => 'ID Tool tidak boleh kosong',
            'id_tool.exists' => 'ID Tool tidak ditemukan',
        ]);
        $barangkeluar = BarangKeluar::findOrFail($id);
        $datapusat = DataPusat::findOrFail($barangkeluar->id_tool);
        $pusat = Datapusat::find($request->id_tool);
        if ($pusat->stok < $request->jumlah) {
               return redirect()->back()
                ->withInput()
                ->with('error', 'Stok Dari Gudang Berisi: ' .$pusat->stok);
        }
            $datapusat->stok +=$barangkeluar->jumlah;
            $datapusat->stok -= $request->jumlah;
            // $datapusat->stok = $datapusat->stok -$barangkeluar->jumlah + $request->jumlah;
            $datapusat->save();

       $barangkeluar->update($request->all());

       $barangkeluar->save();
        return redirect()->route('barangkeluar.index')->with('success', 'Data Berhasil Masuk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $keluar = Barangkeluar::findorfail($id);
        $keluar->delete();
        return redirect()->route('barangkeluar.index')->with('success', 'Data Berhasil Dihapus');
    }
}
