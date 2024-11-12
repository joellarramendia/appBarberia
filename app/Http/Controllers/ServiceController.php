<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    
    public function createService(Request $request){
        //validar los datos
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer|min:0', // Asegura que el precio sea un entero
            'duration' => 'required',
        ]);

        //crear el servicio
        $service = new Service();
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->price = $request->input('price');
        $service->duration = $request->input('duration');
        $service->save();

        //retornar el servicio creado
        return response()->json($service);

       /* Service::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
        ]);*/
    }
}
