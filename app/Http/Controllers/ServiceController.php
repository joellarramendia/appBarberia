<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
     //obtener todos los servicios
     public function index(){
        $services = Service::all();
        return view('services.index', compact('services'));
    }


    //crear un servicio
    public function createService(Request $request){
        // Validar los datos del formulario
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string|max:1000',
        'duration' => 'required|numeric|min:1', // Validar duración mayor a 0
        ]);

        // Si la validación pasa, se crea el servicio
        $service = new Service();
        $service->name = $validated['name'];
        $service->price = $validated['price'];
        $service->description = $validated['description'];
        $service->duration = $validated['duration'];
        $service->save();

        return response()->json(['success' => true, 'message' => 'Servicio guardado correctamente']);
       
    }

    //obtener un servicio
    public function getService($service_id){
        $service = Service::find($service_id);
        return response()->json($service);
    }

    //funcion para editar un servicio
    public function updateService(Request $request, $service_id){
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'duration' => 'required|numeric|min:1', // Validar duración mayor a 0
        ]);

        // Si la validación pasa, se actualiza el servicio
        $service = Service::find($service_id);
        $service->name = $validated['name'];
        $service->price = $validated['price'];
        $service->description = $validated['description'];
        $service->duration = $validated['duration'];
        $service->save();

        return response()->json(['success' => true, 'message' => 'Servicio actualizado correctamente']);
    }

    //funcion para eliminar un servicio
    public function deleteService($service_id){
        $service = Service::find($service_id);
        $service->delete();
        return response()->json(['message' => 'Service deleted']);
    }
    
}
