<?php

namespace App\Http\Controllers;

use App\Models\Gamer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
<<<<<<< Updated upstream
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
=======
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
>>>>>>> Stashed changes

class GamerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'id' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Unauthorized', 'errors' => $validator->errors()], 401);
        }
        // Fetch the specific gamer using the provided ID
        $gamer = Gamer::find($request->input('id'));

        // Check if the gamer exists
        if (!$gamer) {
            return response()->json(['message' => 'Gamer not found'], 404);
        }

        // Return a JSON response with the gamer data and a success message
        return response()->json([
            'id' => $gamer->id,
            'name' => $gamer->name,
            'dob' => $gamer->dob,
            'email' => $gamer->email,
            'phone_number' => $gamer->phone_number,
            'image_url' => $gamer->image_url,
        ], 200);
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
            return response()->json($validator->errors(), 422);
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
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|required',
            'password' => 'sometimes|min:8',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'phone_number' => 'sometimes|required|starts_with:628|min:10|max:16',
            'dob' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->name = $request->input('username');
        $user->email = $request->input('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->phone_number = $request->input('phone_number');
        $user->dob = $request->input('dob');

        $user->save();

        return response()->noContent(201);
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
