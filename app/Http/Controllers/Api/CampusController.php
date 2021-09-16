<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampusResource;
use App\Models\Campus;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use function MongoDB\BSON\toJSON;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campuses = Campus::all();
        return CampusResource::collection($campuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kampus' => 'required|max:255',
            'deskripsi' => 'required|string',
            'alamat_kampus' => 'required|string',
            'tanggal_dibangun' => 'required|date',
            'foto_kampus' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'peta_kampus' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->foto_kampus->getClientOriginalExtension();
        $request->foto_kampus->move(public_path('images/kampus'), $imageName);
        $petaName = time().'.'.$request->peta_kampus->getClientOriginalExtension();
        $request->peta_kampus->move(public_path('images/kampus/peta'), $petaName);

        $kampus = Campus::create([
            'nama_kampus' => $request->nama_kampus,
            'deskripsi' => $request->deskripsi,
            'alamat_kampus' => $request->alamat_kampus,
            'peta_kampus' => $petaName,
            'tanggal_dibangun' => $request->tanggal_dibangun,
            'foto_kampus' => $imageName
        ]);
        return response()->json('Data Kampus ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campus = Campus::findOrFail($id);
        CampusResource::withoutWrapping();

        return new CampusResource($campus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $kampus = Campus::findOrFail($id);
        if($request->hasFile('foto_kampus')){
            $this->validate($request, [
                'nama_kampus' => 'required|max:255',
                'deskripsi' => 'required|string',
                'alamat_kampus' => 'required|string',
                'peta_kampus' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'tanggal_dibangun' => 'required|date',
                'foto_kampus' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $path = public_path().'/images/kampus/';
            $path_peta = public_path().'/images/kampus/peta';

            //code for remove old file
            if($kampus->foto_kampus != ''  && $kampus->foto_kampus != null){
                $file_old = $path.$kampus->foto_kampus;
                unlink($file_old);
            }
            //code for remove old file
            if($kampus->peta_kampus != ''  && $kampus->peta_kampus != null){
                $file_old2 = $path.$kampus->peta_kampus;
                unlink($file_old2);
            }
            //upload new file
            $file = $request->foto_kampus;
            $peta = $request->peta_kampus;
            $filename = time().'.'.$file->getClientOriginalName();
            $Petaname = time().'.'.$peta->getClientOriginalName();
            $file->move($path, $filename);
            $peta->move($path_peta, $Petaname);
            $kampus->update(['foto_kampus' => $filename]);
            $kampus->update(['peta_kampus' => $Petaname]);
            $kampus->update(['nama_kampus' => $request->nama_kampus]);
            $kampus->update(['tanggal_dibangun' => $request->tanggal_dibangun]);
            $kampus->update(['deskripsi' => $request->deskripsi]);
            $kampus->update(['alamat_kampus' => $request->alamat_kampus]);
            return response()->json('Data kampus sukses diupdate', 200);
        } else {
            $this->validate($request, [
                'nama_kampus' => 'required|max:255',
                'deskripsi' => 'required|string',
                'alamat_kampus' => 'required|string',
                'tanggal_dibangun' => 'required|date',
            ]);

            $kampus->update(['nama_kampus' => $request->nama_kampus]);
            $kampus->update(['tanggal_dibangun' => $request->tanggal_dibangun]);
            $kampus->update(['deskripsi' => $request->deskripsi]);
            $kampus->update(['alamat_kampus' => $request->alamat_kampus]);

            return response()->json('Data kampus sukses diupdate', 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campus = Campus::findOrFail($id);
        $image_path = public_path("images/kampus/".$campus->foto_kampus);
        $peta_path = public_path("images/kampus/peta/".$campus->peta_kampus);

        if(file_exists($image_path)){
            //File::delete($image_path);
            File::delete( $image_path);
        }
        if(file_exists($peta_path)){
            //File::delete($image_path);
            File::delete( $peta_path);
        }
        $campus->delete();
        return response()->json('Data Kampus dihapus', 200);
    }
}
