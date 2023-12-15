<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Testing\TestResponse;
class UserController extends Controller
{

    public function login(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => ['required',Password::min(8)]
        ]);

        if ($validator->fails()) {
            return  response()
                ->json(['message' => 'invalid email or password'],400);
        }


        if (Auth::attempt($validator->validated())) {
            $user = User::where('email', $request->email)->first();
            return response()
                ->json([
                    'id'=> $user->id,
                    'role' => $user->role,
                    'token' => $user->createToken($user->role)->plainTextToken
                ],200);
        }

        return response()
                ->json(['message' => 'user tidak terdaftar'],404);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
