<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function upload(Request $request){
        $id = $request->id;
        $file = $request->file('file');
        $fileName = time().'-'.$file->getClientOriginalName();
        $request->file('file')->storeAs($id,$fileName, 'public');//cargar de forma publica
        //$request->file('file')->storeAs($id,$fileName);//cargar de forma privada

        $archivo =new Archivo();
        $archivo->carpeta_id = $request->id;
        $archivo->nombre = $fileName;
            
        $archivo->save();

        toastr()->success('Se actualizó corectamente', 'Notificación');

        return redirect()->back();

    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
