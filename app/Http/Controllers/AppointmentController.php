<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function getAllAppointments()
    {
        try {
            $appointments = Appointment::get();

            return response()->json([
                'message' => 'Appointment retrieved',
                'data' => $appointments
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting Appointments ' .
                $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving appoibntment'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAppointmentByUser($id)
    {
        try {
            $appointments = Appointment::where('patient_id', $id)->get();
            return response()->json([
                'message' => 'Appointments retrieved',
                'data'    =>  $appointments
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting Appointments ' . $th->getMessage());
            return response()->json([
                'message' => 'Error retrieving appointments'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //ejm
    // public function getAppointmentByDescription($description) {
    //     try {
    //         $appointments = Appointment::where('description','like', '%' . $description . '%' )->get();
    //         return response()->json([
    //             'message' => 'Appointments retrieved',
    //             'data'    =>  $appointments
    //         ], Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         Log::error('Error getting Appointments ' . $th->getMessage());

    //         return response()-> json([
    //             'message' => 'Error retrieving appoibntment'
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }


    public function createAppointment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required',
                'dentist_id' => 'required',
                'service_id' => 'required',
                // 'user_id' => 'required'
            ], [
                'patient_id.required' => '!Hace falta un paciente!',
                // 'patient_id.numeric' => 'El nombre debe ser un texto',

                'dentist_id.required' => '!Hace falta un dentista!',
                // 'dentist_id.numeric' => 'El nombre debe ser un texto',

                'service_id.required' => '!Hace falta un servicio!',
                // 'service_id.numeric' => 'El nombre debe ser un texto',

                // 'user_id.required' => '!Hay un error con la clave de usuario!'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $validData = $validator->validated();
            $service = Appointment::create([
                'patient_id' => $validData['patient_id'],
                'dentist_id' => $validData['dentist_id'],
                'service_id' => $validData['service_id'],
            ]);
            return response()->json([
                'message' => 'Appointment created',
                'data'    =>  $service
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error getting appointment ' . $th->getMessage());
            return response()->json([
                'message' => 'Error creating service'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //UPDATE APPOINTMENT
    public function updateAppointment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'integer',
                'dentist_id' => 'integer',
                'service_id' => 'integer',
                'id' => 'required'
            ],[
                'id' => 'se necesita id'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $validData = $validator->validated();
            $appointment = Appointment::find($validData['id']);
            if (!$appointment) {
                return response()->json([
                    'message' => 'Appointment not found'
                ]);
            }
            if (isset($validData['patient_id'])) {
                $appointment->patient_id = $validData['patient_id'];
            }
            if (isset($validData['dentist_id'])) {
                $appointment->dentist_id = $validData['dentist_id'];
            }
            if (isset($validData['service_id'])) {
                $appointment->service_id = $validData['service_id'];
            }
            $appointment->save();
            return response()->json([
                'message' => 'Appointment updated'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating appointment ' . $th->getMessage());
            return response()->json([
                'message' => 'Error updating appointment'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    // /forma1 sin validate
    // $appointment = Appointment::create([
    //     'description' => $request->input
    //     ('description'),
    //     'user_id' => $request->input
    //     ('user_id'),]);
    //forma1
    // $appointment = new Appointment;
    // $appointment -> description= $request -> input("description");
    // $appointment -> user_id= $request -> input("user_id");
    //     $appointment-> save();
}
