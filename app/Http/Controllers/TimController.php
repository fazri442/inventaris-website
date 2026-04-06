<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;

class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tim = Tim::all();
        return view('tim.index', compact('tim'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tim.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_anggota_tim' => 'required',
            'lokasi_tim' => 'required',
            'pemimpin_tim' => 'required',
            'kontak_tim' => 'required',
            ]);
            
            $tim = new Tim;
            $lastRecord = Tim::latest('id')->first();
            $lastId = $lastRecord ? $lastRecord->id : 0;
            $kode_tim = 'TIM-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
            $tim->kode_tim = $kode_tim;
            $tim->nama_anggota_tim = $request->nama_anggota_tim;
            $tim->lokasi_tim = $request->lokasi_tim;
            $tim->pemimpin_tim = $request->pemimpin_tim;
            $tim->kontak_tim = $request->kontak_tim;
            $tim->save();

        return redirect()->route('tim.index')->with('success', 'Tim created successfully.');
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
        $tim = Tim::findOrFail($id);
        return view('tim.edit', compact('tim'));
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
        $request->validate([
            'nama_anggota_tim' => 'required',
            'lokasi_tim' => 'required',
            'pemimpin_tim' => 'required',
            'kontak_tim' => 'required',
        ]);

        $tim = Tim::findOrFail($id);
        $tim->update($request->all());

        return redirect()->route('tim.index')->with('success', 'Tim updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Tim::findOrFail($id);
        $data->delete();
        return redirect()->route('tim.index')->with('success', 'Tim deleted successfully.');
    }
}
