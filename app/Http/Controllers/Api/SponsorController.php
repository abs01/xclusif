<?php

namespace App\Http\Controllers\Api;
use App\Models\Sponsors;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SponsorController extends Controller
{


        //Simulación de algoritmo de selección de patrocinador activo
      public function index()
{
    $sponsor = Sponsors::where('is_active', true)->inRandomOrder()->first();

    return response()->json([
        'success' => true,
        'data' => $sponsor,
        'message' => 'Sponsor retrieved successfully'
    ]);
}
}
