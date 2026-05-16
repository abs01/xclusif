<?php

namespace App\Http\Controllers;

use App\Models\Earning;

class EarningCRUDController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Earning::with(['user', 'post']);        

        $earnings = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('earnings.index', compact('earnings'));
    }

 
    /**
     * Display the specified resource.
     */
    public function show(Earning $earnings){
      $earnings->load(['user', 'post']);
      return view('earnings.show', compact('earnings'));
    }
}
