<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class ServiceController extends Controller
{
     //obtener todos los servicios
     public function index(){

        $services = Service::all();
        $user = auth()->user(); // Obtiene el usuario autenticado
        return view('services.index', compact('user','services'));
    }


    //crea un servicio
    public function createService(Request $request){
        // Valida los datos del formulario
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:1',
        'description' => 'required|string|max:1000',
        'duration' => 'required|numeric|min:1', // Valida duración mayor a 0
        ]);

        // Si la validación pasa, se crea el servicio
        $service = new Service();
        $service->name = $validated['name'];
        $service->price = $validated['price'];
        $service->description = $validated['description'];
        $service->duration = $validated['duration'];
        $service->save();

        //return response()->json(['success' => true, 'message' => 'Servicio guardado correctamente']);*/
        //$service = Service::create($validatedData);

        return response()->json(['service' => $service], 201);
       
    }

    //obtiene un servicio
    public function getService($service_id){
        $service = Service::find($service_id);
        return response()->json($service);
    }

    //funcion para editar un servicio
    public function updateService(Request $request, $service_id){
        // Valida los datos del formulario
        $validated = $request->validate([
            'editName' => 'required|string|max:255',
            'editPrice' => 'required|numeric|min:0',
            'editDescription' => 'required|string|max:1000',
            'editDuration' => 'required|numeric|min:1',
        ]);

        // Busca el servicio
        $service = Service::find($service_id);

        // Verificar si el servicio existe
        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Servicio no encontrado'], 404);
        }

        try {
            // Actualizar los datos
            $service->update([
                'name' => $validated['editName'],
                'price' => $validated['editPrice'],
                'description' => $validated['editDescription'],
                'duration' => $validated['editDuration'],
            ]);

            return response()->json(['success' => true, 'message' => 'Servicio actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el servicio', 'error' => $e->getMessage()], 500);
        }
    }


    //funcion para eliminar un servicio
    public function deleteService($service_id){
        try {
            $service = Service::find($service_id);

            if (!$service) {
                return response()->json([
                    'success' => false,
                    'message' => 'Servicio no encontrado.',
                ], 404);
            }

            $service->delete();

            return response()->json([
                'success' => true,
                'message' => 'Servicio eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al eliminar el servicio.',
            ], 500);
        }
    }

    
}
