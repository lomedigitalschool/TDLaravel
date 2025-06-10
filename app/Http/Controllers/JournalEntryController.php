<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JournalEntryController extends Controller
{

      use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = Auth::user()->journalEntries()->latest()->get();
        return view('journal.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('journal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'humeur' => 'nullable|in:heureux,triste,stressé,fatigué,motivé',
            'image' => 'nullable|image|max:2048',
            'est_public' => 'boolean',
            
            
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('journal_images', 'public');
        }

        Auth::user()->journalEntries()->create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'humeur' => $request->humeur,
            'image' => $imagePath,
            'est_public' => $request->has('est_public'),
        ]);

      

        return redirect()->route('journal.index')->with('success', 'Entrée ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
   public function show(JournalEntry $journalEntry)
{
    if ($journalEntry->user_id !== Auth::id() && !$journalEntry->est_public) {
        abort(403, 'Tu n\'as pas accès à cette entrée.');
    }

    return view('journal.show', compact('journalEntry'));
}

    /**
     * Show the form for editing the specified resource.
     */
   

     public function edit(JournalEntry $journalEntry)
    {
         $this->authorize('update', $journalEntry);
        return view('journal.edit', compact('journalEntry'));
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JournalEntry $journalEntry)
    {
        $this->authorize('update', $journalEntry);

        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'humeur' => 'nullable|in:heureux,triste,stressé,fatigué,motivé',
            'image' => 'nullable|image|max:2048',
            'est_public' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($journalEntry->image) {
                Storage::disk('public')->delete($journalEntry->image);
            }
            $journalEntry->image = $request->file('image')->store('journal_images', 'public');
        }

        $journalEntry->update([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'humeur' => $request->humeur,
            'est_public' => $request->has('est_public'),
        ]);

        return redirect()->route('journal.index')->with('success', 'Entrée modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */

     public function destroy(JournalEntry $journalEntry)
   {
    $this->authorize('delete', $journalEntry);
    
   }
    

    public function publicEntries()
    {
        $entries = JournalEntry::where('est_public', true)->latest()->get();
        return view('journal.public', compact('entries'));
    }
}