<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::Where("user_id", Auth::id())->latest('updated_at')->paginate(3);
        // $notes->each(function ($note) {
        //     dump($note->title);
        // });
        // dd($notes); 

        return view('notes.index')->with('notes', $notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required|max:5000'
        ]);

        Note::create([
            'uuid' => Str::uuid(),
            'user_id' => Auth::id(),
            'title' => $request->title,
            'text' => $request->text
        ]);

        return to_route('notes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if($note->user_id != Auth::id()) {
            return abort(403);
        }

        return view('notes.show')->with('note', $note);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if($note->user_id != Auth::id()) {
            return abort(403);
        }
        
        return view('notes.edit')->with('note', $note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        // If it's the authorized user, all of this is done.
        if($note->user_id != Auth::id()) {
            return abort(403);
        }

        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required|max:5000'
        ]);

        $note->update([
            'title' => $request->title,
            'text'=> $request->text
        ]);

        return to_route('notes.show', $note)->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if($note->user_id != Auth::id()) {
            return abort(403);
        }

        $note->delete();
        
        return to_route('notes.index')->with('success', 'Note deleted sucessfully');
    }
}
