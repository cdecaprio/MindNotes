<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notes;
use Inertia\Inertia;

class NotesController extends Controller
{
    public function index()
    {
        $notes = auth()->user()->notes()->latest()->get();
        return Inertia::render('Notes/Index', [
            'notes' => $notes
        ]);
    }

    public function create()
    {
        return Inertia::render('Notes/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $note = new notes();
        $note->title = $validated['title'];
        $note->content = $validated['content'];
       
        $note->latitude = $validated['latitude'];
        $note->longitude = $validated['longitude'];
        $note->user_id = auth()->id();
        $note->save();

        return redirect()->back()->with('success', 'Nota creada correctamente');
    }

    public function show(notes $note)
    {
        $this->authorize('view', $note);
        return Inertia::render('Notes/Show', [
            'note' => $note
        ]);
    }

    public function edit(notes $note)
    {
        $this->authorize('update', $note);
        return Inertia::render('Notes/Edit', [
            'note' => $note
        ]);
    }

    public function update(Request $request, notes $note)
    {
        $this->authorize('update', $note);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'folder' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
        ]);

        $note->update($validated);

        return redirect()->back()->with('success', 'Nota actualizada correctamente');
    }

    public function destroy(notes $note)
    {
        $this->authorize('delete', $note);
        
        $note->delete();

        return redirect()->back()->with('success', 'Nota eliminada correctamente');
    }

    public function summ(notes $note)
    {
        $this->authorize('summ', $note);
        $summary = $note->summ();
        return Inertia::render('Notes/summ', [
            'summ' => $summ
        ]);
    }
}
