<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HandleTransaction;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    use HandleTransaction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Gate::authorize('user', User::class);
            $users = User::all();
            $foremattedData = UserResource::collection($users);
            return response()->json($foremattedData);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        Gate::authorize('user', User::class);
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        };
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found'
            ], 422);
        }
        return $this->handleTransaction(function () use ($data, $user) {
            $user->update($data);
            return $user;
        }, 'Updated successfully', 201);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('user', User::class);
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found'
            ], 422);
        }
        return $this->handleTransaction(function () use ($user) {
            $user->delete();
        }, 'Deleted successfully', 201);
    }
}
