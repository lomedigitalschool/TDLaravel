<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
public function index()
    {
        $todos = auth()->user()->todos;
        return view('home', compact('todos'));
    }


    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        auth()->user()->todos()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('home')->with('success', 'Tâche ajoutée avec succès.');
    }

    public function edit($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'is_completed' => 'nullable|boolean',
        ]);

        $todo->update($request->only(['title', 'description', 'due_date', 'is_completed']));

        return redirect()->route('home')->with('success', 'Tâche mise à jour.');
    }

    public function destroy($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $todo->delete();

        return redirect()->route('home')->with('success', 'Tâche supprimée.');
    }

    public function markAsCompleted($id)
    {
        $todo = auth()->user()->todos()->findOrFail($id);
        $todo->update(['is_completed' => true]);

        return redirect()->route('home')->with('success', 'Tâche marquée comme terminée.');
    }
}
