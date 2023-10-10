<?php

namespace App\Http\Controllers;

use App\Models\CatatanBarang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CatatanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CatatanBarang::paginate(10);
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CatatanBarang $catatanBarang, Request $request)
    {
        $catatanBarang->id_kategori = $request->id_kategori;
        $catatanBarang->nama_barang = $request->nama_barang;
        $catatanBarang->stok_barang = $request->stok_barang;
        $catatanBarang->harga_barang = $request->harga_barang;
        $catatanBarang->save();
        return response()->json([
            'data' => $catatanBarang
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CatatanBarang $catatanBarang, Request $request)
    {
        $data = $catatanBarang->where(
            "id", $request->id
        )->first();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CatatanBarang $catatanBarang, Request $request)
    {
        $data = $catatanBarang->where(
            "id", $request->id
        )->first();

        if($data != null){
            $data->delete();
            $catatanBarang->id_kategori = Uuid::uuid4()->toString();
            $catatanBarang->nama_barang = $request->nama_barang;
            $catatanBarang->stok_barang = $request->stok_barang;
            $catatanBarang->harga_barang = $request->harga_barang;
            $catatanBarang->save();
            return response()->json([
                'data' => $catatanBarang
            ]);
        }

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatatanBarang $catatanBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatatanBarang $catatanBarang, Request $request)
    {
        $data = $catatanBarang->where(
            "id", $request->id
        )->first();

        if($data != null){
            $data->delete();
            return response()->json([
                'message' => "data successfully deleted"
            ]);
        }

        return response()->json([
            "message" => "data is not found"
        ]);
    }
}
