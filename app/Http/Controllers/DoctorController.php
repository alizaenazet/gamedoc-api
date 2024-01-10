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
use App\Models\Group;
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
    public function show(string $userid)
    {
        $user = User::find($userid);
        if (empty($user)) {
            return response()->noContent(404);
        }
        $doctor = $user->doctor;
        $socialMediaList = DB::table('social_media')
            ->select('id','name','url')
            ->where('socialMediaable_id',$doctor->id)
            ->get();
        $response = [
            "id" => $user->id,
            "image_url" => $user->image_url,
            "name" => $user->name,
            "profession" => $doctor->profession,
            "services" => explode(',',$doctor->service),
            'rating' => $doctor->rating,
            "social_media" => $socialMediaList
        ];
        return response()->json($response,200);
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'nullable',
            "profession" => 'nullable',
            "services" => 'nullable',
            "email" => 'nullable|email',
            "deletedSocialMediaId" => 'nullable',
            "social_media" => 'nullable',
            "social_media.*.name" => 'required',
            "social_media.*.url" => 'required',
        ]);
        $user = $request->user();
        $doctor = Doctor::where('user_id',$user->id)->first();
        if (empty($doctor)) {
            return response()->noContent(401);
        }

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $doctor = Doctor::where('user_id',$user->id)->first();

        $validated = $validator->validated();

        if (!empty($validated['name'])) {
            $user->name = $validated['name'];
        }

        if (!empty($validated['profession'])) {
            $doctor->profession = $validated['profession'];
        }

        if (!empty($validated['services'])) {
            $doctor->service = $validated['services'];
        }

        if (!empty($validated['email'])) {
            $user->email = $validated['email'];
        }
        if (!empty($validated['services'])) {
            if (count($validated['services']) > 1) {
                $validated['services'] = implode(",",$validated['services']);
            }else {
                $validated['services'] = $validated['services'][0];
            }
            $doctor->service = $validated['services'];
        }

        if (!empty($validated['deletedSocialMediaId'])) {
            DB::table('social_media')->whereIn('id',$validated['deletedSocialMediaId'])->delete();
        }

        if (!empty($validated['social_media'])) {
            $socialMediaList = $doctor->socialMedias;

            for ($i=0; $i < count($validated['social_media']); $i++) {
                $socialMedia = $validated['social_media'][$i];
                if ($socialMediaList->contains('name',$socialMedia['name'])) {
                    DB::table('social_media')
                     ->where('name',$socialMedia['name'])
                     ->where('socialMediaable_id', $doctor->id)
                     ->update($socialMedia);

                }else{
                $doctor->socialMedias()->createMany($validated['social_media']);
                break;
                }
            }

        }

        if (!$doctor->save()) {
            return response()->noContent(500);
        }
        if (!$user->save()) {
            return response()->noContent(500);
        }
        return "sukses";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
    public function getDoctorGroupListPreview()
    {
        // Mengambil semua data dari model DoctorGroup
        $doctorGroups = Group::all();

        if (count($doctorGroups) > 0) {
            return response()->json($doctorGroups, 200);
        } else {
            return response()->json([], 200);
        }
    }
}
