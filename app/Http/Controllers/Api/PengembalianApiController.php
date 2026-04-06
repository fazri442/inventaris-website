<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Datapusat;
use App\Models\Tim;

class PengembalianApiController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('pusat', 'tim')->get();
        return response()->json([
            'success' => true,
            'message' => 'List of Pengembalian',
            'data' => $pengembalian,
        ], 200);
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::with('pusat', 'tim')->find($id);
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
