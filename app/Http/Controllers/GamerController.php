<?php

namespace App\Http\Controllers;

use App\Models\Gamer;
use App\Models\User;
use App\Models\BoughtGroup;
use App\Models\BougthGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GamerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $request->user();

        // Return a JSON response with the gamer data and a success message
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'dob' => $user->dob,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'image_url' => $user->image_url,
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
    public function getBoughtGroupListPreview($gamerId)
    {
        // Logic untuk mendapatkan daftar grup yang dibeli oleh gamer dengan ID tertentu
        $boughtGroups = BougthGroup::where('gamer_id', $gamerId)->get();

        if ($boughtGroups->count() > 0) {
            // Jika berhasil, response dengan status code 200 OK
            return response()->json($boughtGroups, 200);
        } else {
            // Jika tidak ada data, response dengan status code 200 OK dan pesan empty
            return response()->json([], 200);
        }
    }

    public function buyGroup($gamerId, $groupId)
    {
        // Logic untuk menambahkan grup yang dibeli oleh gamer ke dalam database
        BougthGroup::create([
            'gamer_id' => $gamerId,
            'group_id' => $groupId,
            // tambahkan kolom lain sesuai kebutuhan
        ]);

        // Response sukses dengan status code 200 OK
        return response()->json(['message' => 'Group bought successfully'], 200);
    }
}
