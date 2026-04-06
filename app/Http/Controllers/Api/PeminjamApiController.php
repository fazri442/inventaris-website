<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Datapusat;
use App\Models\Tim;

class PeminjamApiController extends Controller
{
    public function index()
    {
        $peminjam = Peminjaman::with('tim')->get();
        return response()->json([
            'success' => true,
            'message' => 'List of Peminjam',
            'data' => $peminjam,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1',
            'id_tool' => 'required|exists:datapusats,id',
            'id_tim' => 'required|exists:tims,id',
        ]);
        
        $lastId = Peminjaman::max('id') ?? 0;
        $kode_pinjam = 'PINJAM-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $pusat = Datapusat::find($request->id_tool);
        $pusat->stok -= $request->jumlah;
        $pusat->save();

        $peminjam = Peminjaman::create([
            'kode_pinjam' => $kode_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'id_tool' => $request->id_tool,
            'id_tim' => $request->id_tim,
            'status' => 'Sedang Dipinjam',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjam created successfully',
            'data' => $peminjam,
        ], 201);
    }

    public function show($id)
    {
        $peminjam = Peminjaman::with('tim')->find($id);
        if (!$peminjam) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjam not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Peminjam details',
            'data' => $peminjam,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $peminjam = Peminjaman::find($id);
        
        if (!$peminjam) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjam not found',
            ], 404);
        }

        $request->validate([
            'tanggal_pinjam' => 'sometimes|date',
            'tanggal_kembali' => 'sometimes|date|after_or_equal:tanggal_pinjam',
            'id_tim' => 'sometimes|exists:tims,id',
            'status' => 'sometimes|string',
        ]);

        $data = Peminjaman::find($id);
        $pusat = Datapusat::find($request->id_tool);
        $pusat->stok += $data->jumlah;
        $pusat->stok -= $request->jumlah;
        $pusat->save();

        $peminjam->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Peminjam updated successfully',
            'data' => $peminjam,
        ], 200);
    }

    public function destroy($id)
    {
        $peminjam = Peminjaman::find($id);
        
        if (!$peminjam) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjam not found',
            ], 404);
        }

        $pusat = Datapusat::find($peminjam->id_tool);
        $pusat->stok += $peminjam->jumlah;
        $pusat->save();

        $peminjam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Peminjam deleted successfully',
        ], 200);
    }
}
