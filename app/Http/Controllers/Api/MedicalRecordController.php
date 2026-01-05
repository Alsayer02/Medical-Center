<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use App\Http\Resources\RecordResource;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Traits\HandleTransaction;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class MedicalRecordController extends Controller
{
    use HandleTransaction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Gate::authorize('view', MedicalRecord::class);
            $data = MedicalRecord::with('doctor', 'appointment')->get();
            $foremattedData = RecordResource::collection($data);
            return response()->json([
                'status' => true,
                'data' => $foremattedData
            ]);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRecordRequest $request)
    {
        Gate::authorize('create', MedicalRecord::class);
        $data = $request->validated();
        $appointment = Appointment::find($data['appointment_id']);
        if ($appointment->appointment_status !== 'approved') {
            return response()->json([
                'message' => 'Appointment is not approved'
            ], 422);
        }
        return $this->handleTransaction(function () use ($data) {
            $medicalRecord = MedicalRecord::create($data);
            return $medicalRecord;
        }, 'Medical Record  created successfully', 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            Gate::authorize('view', MedicalRecord::class);
            $data = MedicalRecord::with('doctor', 'appointment')->find($id);
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Medical Record not found'
                ], 404);
            }
            $foremattedData = new RecordResource($data);
            return response()->json([
                'status' => true,
                'data' => $foremattedData
            ], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecordRequest $request, $id)
    {
        $data = $request->validated();
        $medicalRecord = MedicalRecord::find($id);
        Gate::authorize('update', $medicalRecord);
        if (!$medicalRecord) {
            return response()->json([
                'message' => 'Medical Record not found'
            ], 404);
        }
        return $this->handleTransaction(function () use ($data, $medicalRecord) {
            $medicalRecord->update($data);
            $medicalRecord->refresh();
            return $medicalRecord;
        }, 'Medical Record  created successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('delete', MedicalRecord::class);
        $record = MedicalRecord::find($id);
        if (!$record) {
            return response()->json([
                'message' => 'Medical Record not found'
            ], 404);
        }
        return $this->handleTransaction(function () use ($record) {
            $record->delete();
        }, 'Medical Record  deleted successfully', 200);
    }
}
