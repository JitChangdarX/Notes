<?php

namespace App\Http\Controllers;

use App\Models\Usermessage;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $notes = Usermessage::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('message', 'like', "%{$search}%")
                         ->orWhere('category', 'like', "%{$search}%");
        })->get();

        return view('notes.dashbord', compact('notes', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Usermessage::create([
            'name' => $request->name,
            'message' => $request->message,
            'category' => $request->category ?? 'others',
            'color' => $request->color ?? '#ffffff',
            'is_pinned' => false,
        ]);

        return redirect()->route('note.index')->with('success', 'Note added successfully');
    }

    public function update(Request $request, $id)
    {
        $note = Usermessage::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $note->update([
            'name' => $request->name,
            'message' => $request->message,
        ]);

        return redirect()->route('note.index')->with('success', 'Note updated successfully');
    }

    public function destroy($id)
    {
        $note = Usermessage::findOrFail($id);
        $note->delete();

        return redirect()->route('note.index')->with('success', 'Note deleted successfully');
    }

    public function togglePin($id)
    {
        $note = Usermessage::findOrFail($id);
        $note->update(['is_pinned' => !$note->is_pinned]);

        return redirect()->route('note.index')->with('success', 'Pin status updated');
    }

    public function restore(Request $request)
    {
        return redirect()->route('note.index')->with('error', 'Restore not implemented');
    }
}
