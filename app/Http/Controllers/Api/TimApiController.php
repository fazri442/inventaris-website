<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tim;
use Illuminate\Support\Facades\Validator;

class TimApiController extends Controller
{
    public function index()
    {
        $tim = Tim::all();
        $res = [
            'succes' => true,
            'message' => 'List Data Tim',
            'data' => $tim,
        ];
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama_anggota_tim' => 'required|string|max:255',
            'lokasi_tim' => 'required|string|max:255',
            'pemimpin_tim' => 'required|string|max:255',
            'kontak_tim' => 'required|string|max:15',
        ]);

        $lastId = Tim::max('id') ?? 0;
        $kode_tim = 'TIM-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $tim = Tim::create([
            'nama_anggota_tim' => $request->nama_anggota_tim,
            'lokasi_tim' => $request->lokasi_tim,
            'pemimpin_tim' => $request->pemimpin_tim,
            'kontak_tim' => $request->kontak_tim,
            'kode_tim' => $kode_tim,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tim created successfully',
            'data' => $tim,
        ], 201);
    }

    public function show($id)
    {
        $tim = Tim::find($id);

        if (!$tim) {
            return response()->json([
                'success' => false,
                'message' => 'Tim not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tim details',
            'data' => $tim,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $tim = Tim::find($id);

        if (!$tim) {
            return response()->json([
                'success' => false,
                'message' => 'Tim not found',
            ], 404);
        }

        $request->validate([
            'nama_anggota_tim' => 'sometimes|required|string|max:255',
            'lokasi_tim' => 'sometimes|required|string|max:255',
            'pemimpin_tim' => 'sometimes|required|string|max:255',
            'kontak_tim' => 'sometimes|required|string|max:15',
        ]);

        $tim->update($request->only(['nama_anggota_tim', 'lokasi_tim', 'pemimpin_tim', 'kontak_tim']));

        return response()->json([
            'success' => true,
            'message' => 'Tim updated successfully',
            'data' => $tim,
        ], 200);
    }

    public function destroy($id)
    {
        $tim = Tim::find($id);

        if (!$tim) {
            return response()->json([
                'success' => false,
                'message' => 'Tim not found',
            ], 404);
        }

        $tim->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tim deleted successfully',
        ], 200);
    }
}
