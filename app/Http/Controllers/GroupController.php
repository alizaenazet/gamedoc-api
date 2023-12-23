<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
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
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required',
            'social_media' => 'required' ,
            'social_media.*.name' => 'required', 
            'social_media.*.url' => 'required',
            "doctors" => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        
        $user = $request->user();
        
        $group = Group::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'] 
        ]);

        $soscialMediaLength = count($request['social_media']);
        
        if (!empty($request['social_media']) && $soscialMediaLength > 0) {
            $group->socialMedias()->createMany($request['social_media']);
        }

        $invitedDoctorLength = count($request['doctors']);
        if (!empty($request['doctors']) && $invitedDoctorLength > 0) {
            $doctorList = $request['doctors'];
            $doctorList[$invitedDoctorLength] = $user->doctor->id;
            $group->doctors()->attach($doctorList);
        }else {
            $group->doctors()->attach($user->doctor->id);
        }

        return response()->noContent(204);
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
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
