<?php

namespace App\Http\Controllers;

use App\Models\Xcoin;

class XcoinCRUDController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Xcoin::with(['user', 'post']);        

        $xcoins = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('xcoins.index', compact('xcoins'));
    }

 
    /**
     * Display the specified resource.
     */
    public function show(Xcoin $xcoinCRUD){
      $xcoinCRUD->load(['user', 'post']);
      return view('xcoins.show', compact('xcoinCRUD'));
    }
}
