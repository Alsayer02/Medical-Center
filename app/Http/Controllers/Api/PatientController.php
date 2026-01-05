<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Traits\HandleTransaction;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;



class PatientController extends Controller
{
    use HandleTransaction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Gate::authorize('view', Patient::class);
            $users = Patient::all();
            $foremattedData = PatientResource::collection($users);
            return response()->json($foremattedData);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePatientRequest $request)
    {
        Gate::authorize('create', Patient::class);
        $data = $request->validated();
        return $this->handleTransaction(function () use ($data) {
            $Patient = Patient::create($data);
            return $Patient;
        }, 'Patient  created successfully', 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        Gate::authorize('view', Patient::class);
        try {
            $patient = Patient::find($id);
            if (!$patient) {
                return response()->json(['message' => 'Patient not found'], 404);
            }
            $foremattedData = new PatientResource($patient);
            return response()->json($foremattedData);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, $id)
    {
        Gate::authorize('update', Patient::class);
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }
        $data = $request->validated();
        return $this->handleTransaction(function () use ($data, $patient) {
            $patient->update($data);
            return $patient;
        }, 'Patient  updated successfully', 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Gate::authorize('delete', Patient::class);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }
        return $this->handleTransaction(function () use ($patient) {
            $patient->delete();
            return $patient;
        }, 'Patient deleted successfully', 200);
    }
}
