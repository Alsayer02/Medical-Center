<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Traits\HandleTransaction;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
{
    use HandleTransaction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Gate::authorize('view', Appointment::class);
            $data = Appointment::with('doctor', 'patient')->paginate(10);
            $foremattedData = AppointmentResource::collection($data);
            return response()->json($foremattedData, 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAppointmentRequest $request)
    {
        Gate::authorize('create', Appointment::class);
        return $this->handleTransaction(function () use ($request) {
            $data = $request->validated();
            $data['appointment_status'] = $data['appointment_status'] ?? 'pending';
            $appointment = Appointment::create($data);
            return new AppointmentResource($appointment);
        }, 'Appoientment created successfully', 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            Gate::authorize('view', Appointment::class);
            $data = Appointment::with('doctor', 'patient')->find($id);
            if (!$data) {
                return response()->json(['message' => 'Appoientment not found'], 404);
            }
            $foremattedData = new AppointmentResource($data);
            return response()->json($foremattedData, 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, $id)
    {
        Gate::authorize('update', Appointment::class);
        $data = $request->validated();
        $appoientment = Appointment::find($id);
        if (!$appoientment) {
            return response()->json(['message' => 'Appoientment not found'], 404);
        }
        return $this->handleTransaction(function () use ($appoientment, $request) {
            $appoientment->update($request->validated());
            return $appoientment;
        }, 'Appoientment updated successfully', 200);
    }
    // }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('delete', Appointment::class);
        $appoientment = Appointment::find($id);
        if (!$appoientment) {
            return response()->json(['message' => 'Appoientment not found'], 404);
        }
        return $this->handleTransaction(function () use ($appoientment) {
            $appoientment->delete();
            return $appoientment;
        }, 'Appointment deleted successfully', 200);
    }
}
