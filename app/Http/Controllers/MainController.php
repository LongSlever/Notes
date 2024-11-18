<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        // LOAD USEr'S NOTES
        $id = session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        //show home view
        return view('home', ['notes' => $notes]);
    }

    public function newNote() {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request) {
        //validate request
        $request->validate(
            //rules
            [
                'title' => 'required|max:200',
                'text' => 'required|min:3|max:3000'
            ],
            //error messages
            [
                'title.required' => "O titulo é obrigatório",
                'title.max' => "Titulo deve ser um e-mail válido",
                'text.required' => "O texto é obrigatória",
                'text.min' => "O texto deve ter no mínimo :min caracteres",
                'text.max' => "O texto deve ter no máximo :max caracteres"
            ]
        );

        //get user id

        $id = session('user.id');

        //create new note

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->title;
        $note->text = $request->text;
        $note->save();

    }

    public function editNote($id) {
        $id = Operations::decryptId($id);

        if($id === null) {
            return redirect()->route('home');
        }

        //load note
        $note = Note::find($id);

        return view ('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request) {
        $request->validate(
            //rules
            [
                'title' => 'required|max:200',
                'text' => 'required|min:3|max:3000'
            ],
            //error messages
            [
                'title.required' => "O titulo é obrigatório",
                'title.max' => "Titulo deve ser um e-mail válido",
                'text.required' => "O texto é obrigatória",
                'text.min' => "O texto deve ter no mínimo :min caracteres",
                'text.max' => "O texto deve ter no máximo :max caracteres"
            ]
            );


            if($request->note_id == null) {
                return redirect()->route('home');
            }

            //decrypt note_id
            $id = Operations::decryptId($request->note_id);

            if($id === null) {
                return redirect()->route('home');
            }

            //load note
            $note = Note::find($id);
            //update note
            $note->title = $request->title;
            $note->text = $request->text;
            $note->save();
            //redirect
            return redirect()->route('home');
    }

    public function deleteNote($id) {
        $id = Operations::decryptId($id);

        if($id === null) {
            return redirect()->route('home');
        }

        //load note

        $note = Note::find($id);

        return view ('delete_note', ['note' => $note]);
    }

    public function deleteConfirm($id) {
        $id = Operations::decryptId($id);

        if($id === null) {
            return redirect()->route('home');
        }

        //load note
        $note = Note::find($id);

        //hard delete
        //$note->delete();
        //soft delete
        //$note->deleted_at = date('Y:m:d H:i:s');
        //$note->save();

        //Soft delete (property in model)
        $note->delete();

        //Hard delete (property in model)
        //$note->forceDelete();
        return redirect()->route('home');
    }

}
