<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Datapusat;

class DataPusatApiController extends Controller
{
    public function index()
    {
        $data = Datapusat::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Pusat',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tool' => 'required|string|max:255',
            'foto' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stok' => 'required|integer',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
        ]);

        $lastId = Datapusat::max('id') ?? 0;
        $kode_tool = 'TOOL-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $data = Datapusat::create([
            'nama_tool' => $request->nama_tool,
            'foto' => $request->foto,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'kode_tool' => $kode_tool,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Pusat created successfully',
            'data' => $data,
        ], 201);
    }

    public function show($id)
    {
        $data = Datapusat::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pusat not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pusat',
            'data' => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = Datapusat::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pusat not found',
            ], 404);
        }

        $request->validate([
            'nama_tool' => 'sometimes|required|string|max:255',
            'foto' => 'sometimes|required|string|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stok' => 'sometimes|required|integer',
            'deskripsi' => 'sometimes|required|string',
            'lokasi' => 'sometimes|required|string|max:255',
        ]);

        $data->update($request->only(['nama_tool', 'foto', 'stok', 'deskripsi', 'lokasi']));

        return response()->json([
            'success' => true,
            'message' => 'Data Pusat updated successfully',
            'data' => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $data = Datapusat::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pusat not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Pusat deleted successfully',
        ], 200);
    }
}
