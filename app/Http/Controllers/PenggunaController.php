<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengguna = Pengguna::paginate(10);
        return response()->json([
            "data" => $pengguna
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Pengguna $pengguna, Request $request)
    {
        $uuid = Uuid::uuid4()->toString();

        $pengguna->id_pengguna = $uuid;
        $pengguna->username = $request->username;
        $pengguna->password = $request->password;
        $pengguna->nama_lengkap = $request->nama_lengkap;
        $pengguna->tanggal_lahir = "";
        $pengguna->alamat = "";
        $pengguna->path_file = "";
        $pengguna->nama_file = "";
        $pengguna->save();

        return $pengguna;
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengguna $pengguna, Request $request)
    {
        $data = $pengguna->where('id_pengguna', $request->id_pengguna)->first();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna, Request $request)
    {
        $data = $pengguna->where([
            "id_pengguna" => $request->id_pengguna
        ]);

        if($data != null){

            $data->delete();

            $request->validate([
                'path_file' => 'required|mimes:pdf,xlx,csv|max:2048',
            ]);
      
            $fileName = time().'-'.$request->path_file->getClientOriginalName();  
       
            $request->path_file->move(public_path('uploads'), $fileName);
    

            $pengguna->id_pengguna = $request->id_pengguna;
            $pengguna->username = $request->username;
            $pengguna->password = $request->password;
            $pengguna->nama_lengkap = $request->nama_lengkap;
            $pengguna->tanggal_lahir = "";
            $pengguna->alamat = $request->alamat;
            $pengguna->path_file = $fileName;
            $pengguna->nama_file = $fileName;
            $pengguna->save();

            return $pengguna;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengguna $pengguna, Request $request){

        $data = $pengguna->where([
            'username' => $request->username,
            'password' => $request->password
        ]);

        $validate = $data->first() == null ? false : true;

        if($validate == true){
            $data->delete();
        }

        return response()->json([
            "message" => $validate == false ? "sorry, data is not found" : "data has been deleted"
        ]);
    }

    //to login user
    public function login(Pengguna $pengguna, Request $request){

        $data = $pengguna->where([
            'username' => $request->username,
            'password' => $request->password
        ])->first();
        $validate = $data == null ? false : true;

        return response()->json([
            "status" => $validate,
            "data" => $data,
        ]);

    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlxs,xlx,docx,doc,csv,txt,png,gif,jpg,jpeg|max:2048',
        ]);
 
        $fileName = $request->file->getClientOriginalName();
        $filePath = 'uploads/' . $fileName;
 
        Storage::disk('public')->put($filePath, file_get_contents($request->file));
        // $path = Storage::disk('public')->url($path);
 
        // Perform the database operation here
 
        return back()
            ->with('success','File has been successfully uploaded.');
    }

    public function getdownload(Request $request)
    {
        return response()->download(public_path('uploads/'.$request->route('filename')));
    }
}
