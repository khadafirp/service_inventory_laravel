<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = KategoriBarang::paginate(10);
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KategoriBarang $kategoriBarang, Request $request)
    {
        
        $id = Uuid::uuid4()->toString();

        $kategoriBarang->id_kategori = $id;
        $kategoriBarang->title_kategori = $request->title_kategori;
        $kategoriBarang->save();

        return response()->json([
            'data' => $kategoriBarang
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriBarang $kategoriBarang, Request $request)
    {
        $data = $kategoriBarang->where(
            "id_kategori", $request->id_kategori
        )->first();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriBarang $kategoriBarang, Request $request)
    {
        $data = $kategoriBarang->where(
            'id_kategori', $request->id_kategori
        )->first();
        if($data != null){
            $data->delete();
            $kategoriBarang->id_kategori = Uuid::uuid4()->toString();
            $kategoriBarang->title_kategori = $request->title_kategori;
            $kategoriBarang->save();

            return response()->json([
                'data' => $kategoriBarang,
                'message' => 'data successfully edited'
            ]);
        }
        return response()->json([
            'data' => $kategoriBarang,
            'message' => 'data has not been edited'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriBarang $kategoriBarang, Request $request)
    {
        $data = $kategoriBarang->where(
            'id_kategori', $request->id_kategori
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
