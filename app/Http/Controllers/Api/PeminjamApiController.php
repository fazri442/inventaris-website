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
        'tanggal_kembali' => 'sometimes|date',
        'id_tim' => 'sometimes|exists:tims,id',
        'id_tool' => 'sometimes|exists:datapusats,id',
        'status' => 'sometimes|string',
        'jumlah' => 'sometimes|integer|min:1',
    ]);

    DB::beginTransaction();
    try {
        // LOGIKA PENGEMBALIAN BARANG (Jika status berubah jadi 'Kembali')
        if ($request->status == 'Kembali' && $peminjam->status != 'Kembali') {
            $pusat = Datapusat::find($peminjam->id_tool);
            if ($pusat) {
                $pusat->increment('stok', $peminjam->jumlah);
            }
        } 
        // LOGIKA UPDATE JUMLAH/BARANG (Jika sedang edit data, bukan sekedar balikin)
        else if ($request->has('jumlah') || $request->has('id_tool')) {
            $oldTool = Datapusat::find($peminjam->id_tool);
            $newToolId = $request->id_tool ?? $peminjam->id_tool;
            $newTool = Datapusat::find($newToolId);
            $newJumlah = $request->jumlah ?? $peminjam->jumlah;

            // Kembalikan stok lama
            if ($oldTool) {
                $oldTool->increment('stok', $peminjam->jumlah);
            }

            // Kurangi stok baru (setelah dipastikan cukup)
            if ($newTool->stok < $newJumlah) {
                throw new \Exception("Stok barang baru tidak mencukupi");
            }
            $newTool->decrement('stok', $newJumlah);
        }

        // Update data di database
        $peminjam->update($request->all());
        
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Peminjam updated successfully',
            'data' => $peminjam,
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
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
