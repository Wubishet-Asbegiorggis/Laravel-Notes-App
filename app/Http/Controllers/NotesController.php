<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure authentication for all methods
        $this->middleware('owner')->only(['show', 'edit', 'destroy']); // Apply 'owner' middleware for specific methods
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->get(); // Retrieve notes belonging to the authenticated user

        $other = Auth::user()->shared ?: collect(); // Ensure $other is a collection
        $notes = $notes->merge($other); // Merge the notes with the shared notes

        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isEdit = false;
        $note = new Note(); // Create an empty note object

        return view('notes.create-edit', compact('isEdit', 'note'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|unique:notes,Title',
            'Description' => 'required',
        ]);

        $note = new Note();
        $note->Title = $request->Title;
        $note->Description = $request->Description;
        $note->user_id = Auth::id(); // Set the user_id to the authenticated user's id
        $note->save();

        if ($request->has('share')) {
            $note->shared()->sync($request->share);
        }

        return redirect()->route('notes.show', $note->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        $isEdit = true;

        return view('notes.create-edit', compact('isEdit', 'note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'Title' => 'required',
            'Description' => 'required',
            'share' => 'array', // Ensure 'share' is an array
        ]);

        // Update the note with validated data
        $note->update([
            'Title' => $request->Title,
            'Description' => $request->Description,
            'user_id' => Auth::id(),
        ]);

        // Sync shared users (many-to-many relationship)
        if ($request->has('share')) {
            $note->shared()->sync($request->share);
        } else {
            $note->shared()->detach();
        }

        return redirect()->route('notes.show', $note->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        // Detach all related users from the note before deleting it
        $note->shared()->detach();

        $note->delete();

        return redirect()->route('notes.index'); // Correct the route name here
    }
}
