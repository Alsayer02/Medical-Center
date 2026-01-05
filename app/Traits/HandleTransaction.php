<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

trait HandleTransaction
{
    /**
     * Execute an action inside a database transaction
     * and return a unified JSON response.
     *
     * @param callable $action
     * @param string $successMessage
     * @param int $successStatus
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleTransaction(
        callable $action,
        string $successMessage = 'Operation successful',
        int $successStatus = 200
    ) {
        DB::beginTransaction();
        try {
            // تنفيذ منطق العملية القادم من الـ Controller
            $result = $action();
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => $successMessage,
                'data'    => $result
            ], $successStatus);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

}
