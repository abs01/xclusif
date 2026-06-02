<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorApiRequest;
use App\Http\Resources\SponsorResource;
use App\Models\Sponsors;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    /**
     * GET /api/sponsors
     * Display a listing of all sponsors
     */
    public function index()
    {
        $sponsors = Sponsors::orderBy('created_at', 'desc')->paginate(15);

        return SponsorResource::collection($sponsors)
            ->additional(['meta' => 'Patrocinadores obtenidos correctamente']);
    }

    /**
     * GET /api/sponsors/{sponsor}
     * Display the specified sponsor
     */
    public function show(Sponsors $sponsor)
    {
        return (new SponsorResource($sponsor))
            ->additional(['meta' => 'Patrocinador obtenido correctamente']);
    }

    /**
     * POST /api/sponsors
     * Store a newly created sponsor
     */
    public function store(SponsorApiRequest $request)
    {
        $validated = $request->validated();

        $sponsor = Sponsors::create($validated);

        return (new SponsorResource($sponsor))
            ->additional(['meta' => 'Patrocinador creado correctamente']);
    }

    /**
     * PUT /api/sponsors/{sponsor}
     * Update the specified sponsor
     */
    public function update(SponsorApiRequest $request, Sponsors $sponsor)
    {
        $sponsor->update($request->validated());

        return (new SponsorResource($sponsor))
            ->additional(['meta' => 'Patrocinador actualizado correctamente']);
    }

    /**
     * DELETE /api/sponsors/{sponsor}
     * Remove the specified sponsor
     */
    public function destroy(Sponsors $sponsor)
    {
        $sponsor->delete();

        return response()->json(['meta' => 'Patrocinador eliminado correctamente']);
    }
}
