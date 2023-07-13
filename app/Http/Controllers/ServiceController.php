<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    //

    public function getAllServices()
    {
        try {
            $services = Service::get();
            return response()->json([
                'message' => 'Services retrieved',
                'data' => $services
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting services ' .
                $th->getMessage());
            return response()->json([
                'message' => 'Error retrieving services'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function createService(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'price' => 'required|numeric',
                'description' => 'required|string',
                'user_id' => 'required'
            ], [
                'name.required' => '!Hace falta un nombre!',
                'name.string' => 'El nombre debe ser un texto',
                'price.required' => '!Hace falta un precio!',
                'price.numeric' => 'El precio debe ser un número',
                'description.required' => '!Hace falta una descripción!',
                'description.string' => 'La descripción debe ser un texto',
                'user_id.required' => '!Hay un error con la clave de usuario!'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $validData = $validator->validated();
            $service = Service::create([
                'name' => $validData['name'],
                'price' => $validData['price'],
                'description' => $validData['description'],
                'user_id' => $validData['user_id']
            ]);
            return response()->json([
                'message' => 'Service created',
                'data'    =>  $service
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error getting service ' . $th->getMessage());
            return response()->json([
                'message' => 'Error creating service'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getServiceByDescription($description)
    {
        try {
            $service = Service::where('description', 'like', '%' . $description . '%')->get();

            return response()->json([
                'message' => 'Service retrieved',
                'data' => $service
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting tasks ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving tasks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
