<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapusat;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DataPusatController extends Controller
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
        $datapusat = Datapusat::all();
        return view('datapusat.index', compact('datapusat'));
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
        return view('datapusat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notif = $request->validate([
            'nama_tool' => 'required',
            'foto' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required'
        ],
        [
            'nama_tool.required' => 'Nama Tool Belum diisi',
            'foto.required' => 'Foto Belum Dipilih',
            'stok.required' => 'Stok Belum dimasukan',
            'deskripsi.required' => 'Deskripsi Belum dimasukan',
            'lokasi.required' => 'Lokasi Belum dimasukan',
        ]);
        $data = new Datapusat;
        $lastRecord = DataPusat::latest('id')->first();
        $lastId = $lastRecord ? $lastRecord->id : 0;
        $kodeTool = 'TOOL-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $data->kode_tool = $kodeTool;
        $data->nama_tool = $request->nama_tool;
        if($request->hasFile('foto')){
            $img = $request->file('foto');
            $name = rand(1000,9999).$img->getClientOriginalname();
            $img->move('images/dp_foto', $name);
            $data->foto = $name;
        }
        $data->stok = $request->stok;
        $data->deskripsi = $request->deskripsi;
        $data->lokasi = $request->lokasi;
        $data->save();

        return redirect()->route('datapusat.index')->with('success', 'Data berhasil Ditambahkan');
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
        $datapusat = Datapusat::findOrFail($id);
        return view('datapusat.edit', compact('datapusat'));
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
        $notif = $request->validate([
            'nama_tool' => 'required',
            'foto' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required'
        ],
        [
            'nama_tool.required' => 'Nama Tool Belum Diisi Kembali',
            'foto.required' => 'Foto Belum Di pilih Kembali',
            'stok.required' => 'Stok Belum Dimasukan Kembali',
            'deskripsi.required' => 'Deskripsi Belum Dimasukan Kembali',
            'lokasi.required' => 'Lokasi Belum Dimasukan Kembali',
        ]);
        $data = Datapusat::findOrFail($id);
        $data->nama_tool = $request->nama_tool;
        $data->foto = $request->foto;
        $data->stok = $request->stok;
        $data->deskripsi = $request->deskripsi;
        $data->lokasi = $request->lokasi;

            if($request->hasFile('foto')){
            $data->deleteImage();
            $img = $request->file('foto');
            $name = rand(1000,9999) . $img->getClientOriginalName();
            $img->move('images/dp_foto', $name);
            $data->foto = $name;
        }
        $data->save() ;

        return redirect()->route('datapusat.index')->with('success', 'Data berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Datapusat::findorfail($id);
        if ($data->foto && file_exists(public_path('images/dp_foto/' . $data->foto))) {
            unlink(public_path('images/dp_foto/' . $data->foto));
        }
        $data->delete();
        return redirect()->route('datapusat.index')->with('success', 'Data Berhasil Dihapus');
    }
}
