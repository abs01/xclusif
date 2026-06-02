<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsors;
use App\Http\Requests\SponsorRequest;
use App\Http\Requests\GuardarImagenRequest;
use Exception;
use Illuminate\Support\Facades\File;

class SponsorCRUDController extends Controller
{
    /**
     * Display a listing of sponsors
     */
    public function index(Request $request)
    {
        $query = Sponsors::query();

        // Filter by company name
        if ($request->has('company_name') && $request->company_name) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }

        // Filter by active status
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        $sponsors = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new sponsor
     */
    public function create()
    {
        return view('sponsors.create');
    }

    /**
     * Store a newly created sponsor in storage
     */
    public function store(SponsorRequest $request)
    {
        try {
            $validated = $request->validated();
            unset($validated['file_path']);
            
            $sponsor = Sponsors::create($validated);

            // Handle file upload if present
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $filename = time() . '.' . $file->extension();
                $file->move(public_path('images'), $filename);

                $sponsor->update([
                    'file_path' => $filename,
                ]);
            }

            return redirect()->route('sponsorCRUD.index')
                ->with('success', 'Patrocinador creado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('sponsorCRUD.index')
                ->with('error', 'Error al crear el patrocinador: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified sponsor
     */
    public function show(Sponsors $sponsorCRUD)
    {
        return view('sponsors.show', ['sponsor' => $sponsorCRUD]);
    }

    /**
     * Show the form for editing the specified sponsor
     */
    public function edit(Sponsors $sponsorCRUD)
    {
        return view('sponsors.edit', ['sponsor' => $sponsorCRUD]);
    }

    /**
     * Update the specified sponsor in storage
     */
    public function update(SponsorRequest $request, Sponsors $sponsorCRUD)
    {
        try {
            $validated = $request->validated();
            unset($validated['file_path']);
            
            $sponsorCRUD->update($validated);

            // Handle file upload if present
            if ($request->hasFile('file_path')) {
                // Delete old image if exists
                if ($sponsorCRUD->file_path) {
                    $oldPath = public_path('images/' . $sponsorCRUD->file_path);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('file_path');
                $filename = time() . '.' . $file->extension();
                $file->move(public_path('images'), $filename);

                $sponsorCRUD->update([
                    'file_path' => $filename,
                ]);
            }

            return redirect()->route('sponsorCRUD.show', $sponsorCRUD)
                ->with('success', 'Patrocinador actualizado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('sponsorCRUD.edit', $sponsorCRUD)
                ->with('error', 'Error al actualizar el patrocinador: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified sponsor from storage
     */
    public function destroy(Sponsors $sponsorCRUD)
    {
        try {
            $sponsorCRUD->delete();

            return redirect()->route('sponsorCRUD.index')
                ->with('success', 'Patrocinador eliminado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('sponsorCRUD.index')
                ->with('error', 'Error al eliminar el patrocinador: ' . $e->getMessage());
        }
    }

    /**
     * Store an image for the specified sponsor.
     */
    public function image(GuardarImagenRequest $request, Sponsors $sponsorCRUD)
    {
        try {
            $file = $request->file('file_path');
            $filename = time() . '.' . $file->extension();
            $file->move(public_path('images'), $filename);

            $sponsorCRUD->update([
                'file_path' => $filename,
            ]);

            return redirect()->route('sponsorCRUD.show', $sponsorCRUD)
                ->with('success', 'Imagen subida correctamente');
        } catch (Exception $e) {
            return redirect()->route('sponsorCRUD.show', $sponsorCRUD)
                ->with('error', 'Error al subir imagen: ' . $e->getMessage());
        }
    }

    /**
     * Remove an image from the sponsor.
     */
    public function destroyImage(Sponsors $sponsorCRUD)
    {
        try {
            if ($sponsorCRUD->file_path) {
                $mediaPath = public_path('images/' . $sponsorCRUD->file_path);
                if (File::exists($mediaPath)) {
                    File::delete($mediaPath);
                }

                $sponsorCRUD->update([
                    'file_path' => null,
                ]);
            }

            return redirect()->route('sponsorCRUD.show', $sponsorCRUD)
                ->with('success', 'Imagen eliminada correctamente');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar imagen: ' . $e->getMessage());
        }
    }
}
