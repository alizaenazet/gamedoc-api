<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\FavoriteDoctor;
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
    public function GetHealthReport($gamerId)
    {

        $gamer = Gamer::find($gamerId);

        if (!$gamer) {
            return response()->json(['message' => 'Gamer not found'], 404);
        }

        $healthReport = $gamer->healthReport;

        if (!$healthReport) {
            return response()->json(['message' => 'Health report not found'], 404);
        }
        return response()->json([
            'fisik' => $healthReport->fisik,
            'mental' => $healthReport->mental,
            'sosial' => $healthReport->sosial,
            'berhenti_bermain' => $healthReport->berhenti_bermain,
            'motivasi_beraktivitas' => $healthReport->motivasi_beraktivitas,
            'nyeri_tulang_sendi' => $healthReport->nyeri_tulang_sendi,
            'keluhan_mengganggu_aktivitas' => $healthReport->keluhan_mengganggu_aktivitas,
            'nyaman_menghabiskan_waktu_untuk_game' => $healthReport->nyaman_menghabiskan_waktu_untuk_game,
            'kesulitan_bersosialisasi_keluhan_gamer' => $healthReport->kesulitan_bersosialisasi_keluhan_gamer,
            'gangguan_tidur' => $healthReport->gangguan_tidur,
            'durasi_bermain' => $healthReport->durasi_bermain,
            'bersalah_berlebihan_bermain' => $healthReport->bersalah_berlebihan_bermain,
        ], 200);
    }

    public function addFavoriteDoctor(Request $request, string $doctorId)
    {
        $doctor = Doctor::find($doctorId);
        if (empty($doctor)) {
            return response()->noContent(404);
        }
        $gamer = $request->user()->gamer;

        $alredyRelation = FavoriteDoctor::where('gamer_id', $gamer->id)
            ->where('doctor_id', $doctorId)
            ->get();

        if (count($alredyRelation) >= 1) {
            return response()->noContent(400);
        }

        $addRelation = FavoriteDoctor::create([
            'doctor_id' => $doctorId,
            'gamer_id' => $gamer->id
        ]);

        if (!empty($addRelation)) {
            return response()->noContent(200);
        }

        return response()->noContent(500);
    }
}
