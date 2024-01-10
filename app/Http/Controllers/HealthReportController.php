<?php

namespace App\Http\Controllers;

use App\Models\HealthReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HealthReportController extends Controller
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
    public function show(HealthReport $healthReport)
    {
        //
    }

    public function updateHealthReport(Request $request) {
        $validator = Validator::make($request->all(), [
            "fisik" => 'nullable',
            "mental" => 'nullable',
            "sosial" => 'nullable',
            "berhenti_bermain" => 'nullable',
            "motivasi_beraktivitas" => 'nullable',
            "nyeri_tulang_sendi" => 'nullable',
            "nyaman_menghabiskan_waktu_untuk_game" => 'nullable',
            "kesulitan_bersosialiasi" => 'nullable',
            "keluhan_gamer" => 'nullable',
            "isgangguan_tidur" => 'nullable',
            "isbersalah_berlebihan_bermain" => 'nullable',
            "keluhan_menggangu_aktivitas" => 'nullable',
            "durasi_bermain" => 'nullable',
            "bersalah_berlebihan_bermain" => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $gamer = $request->user()->gamer;
        // return empty($gamer->healtReport);
        $isAlreadyCreated = DB::table('health_reports')->where('gamer_id',$gamer->id)->exists();

        $validatedHealthReport = $validator->validated();

        if (count($validatedHealthReport['keluhan_gamer']) > 1) {
            $validatedHealthReport['keluhan_gamer'] = implode(",",$validatedHealthReport['keluhan_gamer']);
        }else {
            $validatedHealthReport['keluhan_gamer'] = $validatedHealthReport['keluhan_gamer'][0];
        }

        if ($isAlreadyCreated) {
            DB::table('health_reports')
            ->where('gamer_id', $gamer->id)
            ->update($validatedHealthReport);
            return response()->noContent(204);
        }
        
        // return $validator->validated();
        $isSuccess = !empty(
            $gamer->healtReport()->create(
                $validatedHealthReport
            ));
        
        if ($isSuccess) {
            return response()->noContent(204);
        }else{
            return response()->noContent(400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HealthReport $healthReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HealthReport $healthReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HealthReport $healthReport)
    {
        //
    }
}
