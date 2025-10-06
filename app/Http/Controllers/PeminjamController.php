<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapusat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
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

            return view('peminjam.index', compact('pinjam'));
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
        $datapusat = Datapusat::all();
        return view('peminjam.create', compact('datapusat'));
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
            'jumlah' => 'required|numeric',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'nama_peminjam' => 'required|max:255'
        ],
        [
            'jumlah|required|numeric' => 'Jumlah Belum Dimasukan',
            'tanggal_pinjam|required|date' => 'Tanggal Belum Dilih',
            'tanggal_kembali|required|date' => 'Tanggal Kembalikan Belum Dipilih',
            'nama_peminjam|required|max:255' => 'Nama Belum Dimasuksan'
        ]);
        $data = new Peminjaman;
        $lastRecord = Peminjaman::latest('id')->first();
        $lastId = $lastRecord ? $lastRecord->id : 0;
        $kodeBarang = 'PJB-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $data->kode_barang = $kodeBarang;
        $data->id_barang = $request->id_barang;

        $data->jumlah = $request->jumlah;
        $data->tanggal_pinjam = $request->tanggal_pinjam;
        $data->tanggal_kembali = $request->tanggal_kembali;
        $data->nama_peminjam = $request->nama_peminjam;
        $data->status = "Sedang Dipinjam";

        $pusat = DataPusat::findOrFail($request->id_barang);
        if ($pusat->stok < $request->jumlah) {
            return redirect()->route('peminjam.index');
        } else {
            $pusat->stok -= $request->jumlah;
            $pusat->save();
        }
        $data->save();

        return redirect()->route('peminjam.index')->with('success', 'Data berhasil Ditambahkan');
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
        $peminjam = Peminjaman::findorfail($id);
        $datapusat = Datapusat::all();
        return view('peminjam.edit', compact('peminjam', 'datapusat'));
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
            'jumlah' => 'required|numeric',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'nama_peminjam' => 'required|max:255'
        ],
        [
            'jumlah|required|numeric' => 'Jumlah Belum Dimasukan',
            'tanggal_pinjam|required|date' => 'Tanggal Belum Dilih',
            'tanggal_kembali|required|date' => 'Tanggal Kembalikan Belum Dipilih',
            'nama_peminjam|required|max:255' => 'Nama Belum Dimasuksan'
        ]);
        $peminjam = Peminjaman::findOrFail($id);
        $datapusat = Datapusat::findOrFail($peminjam->id_barang);
        // status pengembalian
        if ($request->status == "Sudah Dikembalikan") {
            $datapusat->stok += $peminjam->jumlah;
            $datapusat->save();
        }
    
        //logic perubahan ketika update
        if ($datapusat->stok < $request->jumlah) {
            return redirect()->route('peminjam.index');
        } else {
            $datapusat->stok += $peminjam->jumlah;
            $datapusat->stok -= $request->jumlah;
            $datapusat->save();
        }
        
        $datapusat->kode_barang = $request->kode_barang;
        $peminjam->jumlah = $request->jumlah;
        $peminjam->tanggal_pinjam = $request->tanggal_pinjam;
        $peminjam->tanggal_kembali = $request->tanggal_kembali;
        $peminjam->status = $request->status;
        $peminjam->nama_peminjam = $request->nama_peminjam;
        $peminjam->save();
    
        return redirect()->route('peminjam.index')->with('success', 'Data berhasil Dirubah');
    }

    
    //     // jika barang sudah dikembalikan

    //     if ($request->status == "Sudah Dikembalikan") {
    //         // Tambahkan stok barang lama
    //         $barangLama->stok += $peminjaman->jumlah;
    //         $barangLama->save();

    //         $pengembalian = new Pengembalian();
    //         $pengembalian->kode_barang = $kodeBarang;
    //         $pengembalian->jumlah = $peminjaman->jumlah;
    //         $pengembalian->tanggal_kembali = $request->tanggal_kembali;
    //         $pengembalian->nama_peminjam = $peminjaman->nama_peminjam;
    //         $pengembalian->status = $request->status;
    //         $pengembalian->id_peminjam = $peminjaman->id;
    //         $pengembalian->id_barang = $peminjaman->id_barang;
    //         $pengembalian->save();

    //         // Update status peminjaman menjadi "Sudah Dikembalikan"
    //         $peminjaman->status = 'Sudah Dikembalikan';
    //         $peminjaman->save();

    //         Alert::success('Success', 'Data Berhasil Dikembalikan')->autoClose(1500);
    //         return redirect()->route('peminjam.index');
    //     }

    //     // jika barang belum dikembalikan


    //     if ($request->status == "Sedang Dipinjam") {
    //         $jumlahBaru = $request->jumlah;
    //         if ($barangBaru->stok < $jumlahBaru) {
    //             Alert::warning('Warning', 'Stok Tidak Cukup')->autoClose(1500);
    //             return redirect()->route('peminjam.index');
    //         }
    //         if ($peminjaman->id_barang != $request->id_barang) {
    //             // Barang dipinjam berubah
    //             $barangLama->stok += $peminjaman->jumlah;
    //             $barangLama->save();

    //             $barangBaru->stok -= $jumlahBaru;
    //             $barangBaru->save();
    //         } else {
    //             // Barang sama, update stok
    //             $barangLama->stok += $peminjaman->jumlah;
    //             $barangLama->stok -= $jumlahBaru;
    //             $barangLama->save();
    //         }

    //         // Update data peminjaman
    //         $peminjaman->update([
    //             'id_barang' => $request->id_barang,
    //             'jumlah' => $request->jumlah,
    //             'tanggal_pinjam' => $request->tanggal_pinjam,
    //             'tanggal_kembali' => $request->tanggal_kembali,
    //             'status' => $request->status,
    //             'nama_peminjam' => $request->nama_peminjam,
    //         ]);

    //         Alert::success('Success', 'Data Berhasil Diubah')->autoClose(1500);
    //         return redirect()->route('peminjam.index');
    //     }

    //     // Jika status tidak valid
    //     Alert::error('Error', 'Status tidak valid')->autoClose(1500);
    //     return redirect()->route('peminjam.index');
    // }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Peminjaman::findorfail($id);
        $datapusat = Datapusat::findorfail($data->id_barang);
        $datapusat->stok += $data->jumlah;
        $datapusat->save();
        $data->delete();
        return redirect()->route('peminjam.index')->with('success', 'Data Berhasil Dihapus');
    }
}
