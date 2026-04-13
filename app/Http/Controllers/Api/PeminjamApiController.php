<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Datapusat;
use App\Models\Tim;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\DB;

class PeminjamApiController extends Controller
{
    public function index()
    {
        $peminjam = Peminjaman::with(['tim', 'datapusat', 'pengembalian'])->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List of Peminjam',
            'data' => $peminjam,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tim' => 'required|exists:tims,id',
            'id_tool' => 'required|exists:datapusats,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_rencana_kembali' => 'required|date'
        ]);

        DB::beginTransaction();
        try {
            $tool = Datapusat::findOrFail($request->id_tool);

            if ($tool->stok < $request->jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak cukup'
                ], 400);
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

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil',
                'data' => $peminjaman
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        $peminjam = Peminjaman::with(['tim', 'datapusat', 'pengembalian'])->find($id);
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
