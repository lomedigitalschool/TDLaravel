<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class RecetteController extends Controller
{

    use AuthorizesRequests;
    /**
     * Affiche la liste des recettes de l'utilisateur connecté.
     */
    public function index()
    {
        $recettes = Auth::user()->recettes()->latest()->get();

        return view('recettes.index', compact('recettes'));
    }

    /**
     * Affiche le formulaire de création d'une recette.
     */
    public function create()
    {
        return view('recettes.create');
    }

    /**
     * Enregistre une nouvelle recette.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required',
            'ingredients'      => 'required',
            'steps'            => 'required',
            'preparation_time' => 'nullable|integer',
            'type'             => 'nullable|in:petit-déjeuner,déjeuner,dîner',
            'rating'           => 'nullable|integer|min:1|max:5',
            'image'            => 'nullable|image|max:2048',
        ]);

        // Gérer l'image si elle est envoyée
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('recettes', 'public');
        }

        // Ajouter l'ID de l'utilisateur connecté
        $data['user_id'] = Auth::id();

        Recette::create($data);

        return redirect()->route('recettes.index')->with('success', 'Recette ajoutée avec succès !');
    }

    /**
     * Affiche les détails d'une recette.
     */
    public function show(Recette $recette)
    {
        $this->authorize('view', $recette);

        return view('recettes.show', compact('recette'));
    }

    /**
     * Affiche le formulaire d'édition d'une recette.
     */
    public function edit($id)
    {
      $recette = Recette::findOrFail($id); // Vérifie que la recette existe
      return view('recettes.edit', compact('recette'));
    }


    /**
     * Met à jour une recette existante.
     */
    public function update(Request $request, Recette $recette)
    {
        $this->authorize('update', $recette);

        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required',
            'ingredients'      => 'required',
            'steps'            => 'required',
            'preparation_time' => 'nullable|integer',
            'type'             => 'nullable|in:petit-déjeuner,déjeuner,dîner',
            'rating'           => 'nullable|integer|min:1|max:5',
            'image'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('recettes', 'public');
        }

        $recette->update($data);

        return redirect()->route('recettes.index')->with('success', 'Recette mise à jour avec succès !');
    }

    /**
     * Supprime une recette.
     */
    public function destroy(Recette $recette)
    {
        $this->authorize('delete', $recette);

        $recette->delete();

        return redirect()->route('recettes.index')->with('success', 'Recette supprimée avec succès.');
    }
}
