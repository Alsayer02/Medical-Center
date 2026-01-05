<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\User;
use App\Traits\HandleTransaction;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class DoctorController extends Controller
{
    use HandleTransaction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Gate::authorize('doctor', Doctor::class);
            $doctors = Doctor::with('user')->get();
            return response()->json($doctors);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDoctorRequest $request)
    {
        Gate::authorize('doctor', Doctor::class);
        $data = $request->validated();
        return $this->handleTransaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => 'doctor'
            ]);
            $doctor = Doctor::create([
                'name' => $data['name'],
                'specialization' => $data['specialization'],
                'phone' => $data['phone'],
                'user_id' => $user->id
            ]);
            return $doctor;
        }, 'Doctor created successfully', 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        Gate::authorize('doctor', Doctor::class);
        try {
            $doctor = Doctor::with('user')->find($id);
            if (!$doctor) {
                return response()->json(['message' => 'Doctor not found'], 404);
            }
            $foremattedData = new DoctorResource($doctor);
            return response()->json($foremattedData);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, $id)
    {
        Gate::authorize('doctor', Doctor::class);
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }
        $data = $request->validated();
        return $this->handleTransaction(function () use ($data, $doctor) {
            $user = User::find($doctor->user_id);
            if (isset($data['name']) ||  isset($data['phone']) || isset($data['email']) || isset($data['password'])) {
                $user->update([
                    'name' => $data['name'] ?? $user->name,
                    'email' => $data['email'] ?? $user->email,
                    'password' => isset($data['password']) ? bcrypt($data['password']) : $user->password
                ]);
            }
            $doctor->update([
                'name' => $data['name'] ?? $doctor->name,
                'specialization' => $data['specialization'] ?? $doctor->specialization,
                'phone' => $data['phone'] ?? $doctor->phone
            ]);
            return $doctor;
        }, 'Doctor updated successfully', 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('doctor', Doctor::class);
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }
        return $this->handleTransaction(function () use ($doctor) {
            $data = $doctor->toArray();
            $doctor->user->delete();
            $doctor->delete();
            return $data;
        }, 'Doctor deleted successfully', 200);
    }
}
