<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Datapusat;
use App\Models\Tim;

class BarangMasukApiController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('pusat', 'tim')->get();
        return response()->json([
            'success' => true,
            'message' => 'List of Barang Masuk',
            'data' => $barangMasuk,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required|exists:tims,id',
            'jumlah' => 'required|integer',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'lokasi' => 'required|string',
            'id_tool' => 'required|exists:datapusats,id',
        ]);

        $lastId = BarangMasuk::max('id') ?? 0;
        $kode_masuk = 'MASUK-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $pusat = Datapusat::find($request->id_tool);
        $pusat->stok += $request->jumlah;
        $pusat->save();

        $barangMasuk = BarangMasuk::create([
            'nama_tim' => $request->nama_tim,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'lokasi' => $request->lokasi,
            'id_tool' => $request->id_tool,
            'kode_tool' => $kode_masuk,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang Masuk created successfully',
            'data' => $barangMasuk,
        ], 201);
    }

    public function show($id)
    {
        $barangMasuk = BarangMasuk::with('pusat', 'tim')->find($id);

        if (!$barangMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Masuk not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail of Barang Masuk',
            'data' => $barangMasuk,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $barangMasuk = BarangMasuk::find($id);

        if (!$barangMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Masuk not found',
            ], 404);
        }

        $request->validate([
            'nama_tim' => 'required|exists:tims,id',
            'jumlah' => 'required|integer',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'lokasi' => 'required|string',
            'id_tool' => 'required|exists:datapusats,id',
        ]);

        $data = BarangMasuk::find($id);
        $pusat = Datapusat::find($request->id_tool);
        $pusat->stok -= $data->jumlah;
        $pusat->stok += $request->jumlah;
        $pusat->save();

        $barangMasuk->update([
            'nama_tim' => $request->nama_tim,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'lokasi' => $request->lokasi,
            'id_tool' => $request->id_tool,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang Masuk updated successfully',
            'data' => $barangMasuk,
        ], 200);
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::find($id);

        if (!$barangMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Masuk not found',
            ], 404);
        }
        
        $pusat = Datapusat::find($barangMasuk->id_tool);
        $pusat->stok -= $barangMasuk->jumlah;
        $pusat->save();

        $barangMasuk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang Masuk deleted successfully',
        ], 200);
    }
}
