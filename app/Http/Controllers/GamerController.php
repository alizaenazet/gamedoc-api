<?php

namespace App\Http\Controllers;

use App\Models\Gamer;
use Illuminate\Http\Request;

class GamerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gamers = Gamer::all();
        return response()->json($gamers);
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
