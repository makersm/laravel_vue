<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index() {
        return UserResource::collection(User::orderBy('created_at', 'DESC')->paginate(10));
    }

    public function create(Request $request) {
        $user = new User();

        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $result = $user->save();
            info($result);
            if (!$result) return response('error');
        } catch (QueryException $e) {
            info($e->getMessage());
            return response('query error');
        }

        return response('OK');
    }

    public function delete(Request $request) {
        $id = $request->input('id');
        $user = User::find($id);

        try {
            $result = $user->delete();
            if (!$result) return response('error');
        } catch (QueryException $e) {
            info($e->getMessage());
            return response('query error');
        }

        return response('OK');
    }

    public function update(Request $request) {
        $id = $request->input('id');
        $user = User::find($id);

        try {
            $result = $user->update(['name' => $request->input('name'), 'email' => $request->input('email')]);
            if (!$result) return response('error');
        } catch (QueryException $e) {
            info($e->getMessage());
            return response('query error');
        }

        return response('OK');
    }
}
