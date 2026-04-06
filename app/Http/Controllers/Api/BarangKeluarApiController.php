<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Datapusat;
use App\Models\Tim;

class BarangKeluarApiController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('pusat', 'tim')->get();
        return response()->json([
            'success' => true,
            'message' => 'List of Barang Keluar',
            'data' => $barangKeluar,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required|exists:tims,id',
            'jumlah' => 'required|integer',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
            'lokasi' => 'required|string',
            'id_tool' => 'required|exists:datapusats,id',
        ]);

        $lastId = BarangKeluar::max('id') ?? 0;
        $kode_keluar = 'KELUAR-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $pusat = Datapusat::find($request->id_tool);
        $pusat->stok -= $request->jumlah;
        $pusat->save();

        $barangKeluar = BarangKeluar::create([
            'nama_tim' => $request->nama_tim,
            'jumlah' => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
            'lokasi' => $request->lokasi,
            'id_tool' => $request->id_tool,
            'kode_tool' => $kode_keluar,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang Keluar created successfully',
            'data' => $barangKeluar,
        ], 201);
    }

    public function show($id)
    {
        $barangKeluar = BarangKeluar::with('pusat', 'tim')->find($id);

        if (!$barangKeluar) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Keluar not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail of Barang Keluar',
            'data' => $barangKeluar,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::find($id);

        if (!$barangKeluar) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Keluar not found',
            ], 404);
        }

        $request->validate([
            'nama_tim' => 'required|exists:tims,id',
            'jumlah' => 'required|integer',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
            'lokasi' => 'required|string',
            'id_tool' => 'required|exists:datapusats,id',
        ]);

        $data = BarangKeluar::find($id);
        $pusat = Datapusat::find($request->id_tool);
        $pusat->stok += $data->jumlah;
        $pusat->stok -= $request->jumlah;
        $pusat->save();

        $barangKeluar->update([
            'nama_tim' => $request->nama_tim,
            'jumlah' => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
            'lokasi' => $request->lokasi,
            'id_tool' => $request->id_tool,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang Keluar updated successfully',
            'data' => $barangKeluar,
        ], 200);
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::find($id);

        if (!$barangKeluar) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Keluar not found',
            ], 404);
        }

        $pusat = Datapusat::find($barangKeluar->id_tool);
        $pusat->stok += $barangKeluar->jumlah;
        $pusat->save();

        $barangKeluar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang Keluar deleted successfully',
        ], 200);
    }
}
