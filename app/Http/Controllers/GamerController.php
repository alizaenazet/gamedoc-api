<?php

namespace App\Http\Controllers;

use App\Models\Gamer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GamerController extends Controller
{
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
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|unique:users|email',
            'phone_number' => 'required|starts_with:628|min:10|max:16',
            'dob' => 'required|date',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }


        $user = User::create([
            'name' => $request['username'],
            'email' => $request['email'],
            'password' => $request['password'],
            'phone_number' => $request['phone_number'],
            'dob' => $request['dob'],
            'role' => 'gamer'
        ]);

        $user->gamer()->create([]);

        return response()->noContent(201);
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
    public function show(Gamer $gamer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gamer $gamer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gamer $gamer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gamer $gamer)
    {
        //
    }
}
