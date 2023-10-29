<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;


class TrashedNoteController extends Controller
{
    public function index()
    {

        $notes = Note::WhereBelongsTo(Auth::user())->onlyTrashed()->latest('updated_at')->paginate(5);
        return view('notes.index')->with('notes', $notes);
    }

    public function show(Note $note){

        if($note->user_id != Auth::id()) {
            return abort(403);
        }

        
        return view('notes.show')->with('note', $note);
    }
}
