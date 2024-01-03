<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use App\Enums\Proffesion;
use Illuminate\Support\Facades\Storage;




class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users =  DB::table('users')
            ->join('doctors','users.id', '=', 'user_id')
            ->select('users.id','users.image_url','users.name','doctors.profession','doctors.service as services')
        ->get();
        
        $users = $users->map(function ($item, int $key) {
            $item->services = explode(',',$item->services);
            return $item;
        });
        return response()->json($users,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required:min:8',
            'email' => 'required|unique:users|email',
            'dob' => 'required|date',
            'phone_number' => 'required|starts_with:628|min:10|max:16',
            'degree' => 'required',
            'services' => 'required',
            'profession' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        if (count($request['services']) > 1) {
            $request['services'] = implode(",",$request['services']);
        }else {
            $request['services'] = $request['services'][0];
        }
        
        $user = User::create([
            'name' => $request['username'],
            'email' => $request['email'],   
            'password' => $request['password'],
            'phone_number' => $request['phone_number'],
            'dob' => $request['dob'],
            'role' => 'doctor'
        ]);

        DB::table('doctors')->insert([
            'user_id' => $user->id,
            'profession' => $request['profession'],
            'service' => $request['services'],
            'degree' => $request['degree']
        ]);

        return response()->noContent(201);
    }

    public function changeImage(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'image_file' => [
                'required',
                File::types(['png','jpg','jpeg'])
                    ->max('25mb')
            ]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        
        $user = $request->user();
        if (!empty($group->image_url)) {
            $deleteImagePath = str_replace("/storage/",'',$user->image_url);
            if (!Storage::disk('public')->delete($deleteImagePath)) {
                return response()->json("failed to delete existing image",500);
            }
        }

        $file = $request->file('image_file');
        $imageUrl = '/storage/'. $file->storePublicly('users', 'public');

        $user->image_url = $imageUrl;
     
        if ($user->save()) {
            return response()->noContent(204);
        }

        return response()->json("failed to update image url",500);
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
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
