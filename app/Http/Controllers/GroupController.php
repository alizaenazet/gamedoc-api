<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

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

    public function updateImage(Request $request,string $groupid,) {
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

        $group = Group::find($groupid);
        if (empty($group)) {
            return response()->noContent(404);
        }

        if (!empty($group->image_url)) {
            $deleteImagePath = str_replace("/storage/",'',$group->image_url);
            if (!Storage::disk('public')->delete($deleteImagePath)) {
                return response()->json("failed to delete existing image",500);
            }
        }

        $file = $request->file('image_file');
        $imageUrl = '/storage/'. $file->storePublicly('groups', 'public');


        $group->image_url = $imageUrl;

        if ($group->save()) {
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
