<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Datapusat;
use App\Models\Tim;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PengembalianApiController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.datapusat',
            'peminjaman.tim'
        ])->get();

        return response()->json([
            'success' => true,
            'message' => 'List of Pengembalian',
            'data' => $pengembalian,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

            if ($peminjaman->status == 'dikembalikan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah dikembalikan'
                ], 400);
            }

            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'jumlah_dikembalikan' => $peminjaman->jumlah,
                'tanggal_kembali' => now(),
            ]);

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
            ]);

            $tool = Datapusat::find($peminjaman->id_tool);
            $tool->increment('stok', $peminjaman->jumlah);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengembalian berhasil',
                'data' => $pengembalian
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
        $pengembalian = Pengembalian::with([
            'peminjaman.datapusat',
            'peminjaman.tim'
        ])->find($id);

        if (!$pengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Pengembalian not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail of Pengembalian',
            'data' => $pengembalian,
        ], 200);
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::find($id);
        if (!$pengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Pengembalian not found',
            ], 404);
        }

        $pusat = Datapusat::find($pengembalian->id_tool);
        if ($pusat) {
            $pusat->stok -= $pengembalian->jumlah;
            $pusat->save();
        }

        $pengembalian->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengembalian deleted successfully',
        ], 200);
    }
}
