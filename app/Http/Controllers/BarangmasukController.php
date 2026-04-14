<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Datapusat;
use App\Models\Tim;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class BarangmasukController extends Controller
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
        $masuk = BarangMasuk::all();
        $pusat = Datapusat::all();
        return view('masuk.index', compact('masuk', 'pusat'));
    }

    public function export()
    {
        
    $masuk = BarangMasuk::all();

    $pdf = Pdf::loadView('masuk.barangmasuk_pdf', ['masuk' => $masuk]);
    return $pdf->download('laporan-data-masuk.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangmasuk = BarangMasuk::all();
        $datapusat = Datapusat::all();
        $tim = Tim::all();
        return view('masuk.create', compact('barangmasuk', 'datapusat', 'tim'));
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
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'id_tool' => 'required|exists:datapusats,id',
        ],
        [
            'nama_tim.required' => 'Nama tim tidak boleh kosong',
            'nama_tim.string' => 'Nama tim harus berupa teks',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'tglmasuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tglmasuk.date' => 'Format tanggal tidak valid',
            'ket.string' => 'Keterangan harus berupa teks',
            'lokasi.string' => 'Lokasi harus berupa teks',
            'id_tool.required' => 'ID Tool tidak boleh kosong',
            'id_tool.exists' => 'ID Tool tidak ditemukan',
        ]);
        $data = new BarangMasuk;
        $lastRecord = BarangMasuk::latest('id')->first();
        $lastId = $lastRecord ? $lastRecord->id : 0;
        $kodetool = 'MASUK-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        $data->kode_tool = $kodetool;

        $pusat = Datapusat::find($request->id_tool);
        $pusat->stok += $request->jumlah;
        $pusat->save();

        $data->nama_tim = $request->nama_tim;
        $data->jumlah = $request->jumlah;
        $data->tanggal_masuk = $request->tanggal_masuk;
        $data->keterangan = $request->keterangan;
        $data->lokasi = $request->lokasi;
        $data->id_tool = $request->id_tool;

        $data->save();
        return redirect()->route('barangmasuk.index')->with('success', 'Data Berhasil Masuk');
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
        $barangmasuk = BarangMasuk::findorfail($id);
        $tim = Tim::all();
        $datapusat = Datapusat::all();
        return view('masuk.edit', compact('barangmasuk', 'datapusat', 'tim'));
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
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_tool' => 'required|exists:datapusats,id',
        ],
        [
            'nama_tim.required' => 'Nama tim tidak boleh kosong',
            'nama_tim.string' => 'Nama tim harus berupa teks',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
            'keterangan.string' => 'Keterangan harus berupa teks',
            'id_tool.required' => 'ID Tool tidak boleh kosong',
            'id_tool.exists' => 'ID Tool tidak ditemukan',
        ]);
        $data = BarangMasuk::findorfail($id);
        $pusat = Datapusat::findorfail($data->id_tool);
        $pusat->stok -= $data->jumlah;
        $pusat->stok += $request->jumlah;
        $pusat->save();

        $data->nama_tim = $request->nama_tim;
        $data->jumlah = $request->jumlah;
        $data->tanggal_masuk = $request->tanggal_masuk;
        $data->keterangan = $request->keterangan;
        $data->lokasi = $request->lokasi;
        $data->id_tool = $request->id_tool;
        $data->save();

        return redirect()->route('barangmasuk.index')->with('success', 'Data Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = BarangMasuk::findorfail($id);
        $data->delete();
        return redirect()->route('barangmasuk.index')->with('success', 'Data Berhasil Dihapus');
    }
}
