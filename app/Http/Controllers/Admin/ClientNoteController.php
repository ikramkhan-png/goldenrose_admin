<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientNote;
use App\Models\ClientQuery;
use Illuminate\Http\Request;

class ClientNoteController extends Controller
{
    /**
     * Store a new note for a client
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('client_notes', 'public');
        }

        ClientNote::create([
            'client_id' => $request->client_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'document' => $documentPath,
            'is_read' => false,
        ]);

        return back()->with('success', 'Note sent to client successfully.');
    }

    /**
     * Delete a note
     */
    public function destroy($id)
    {
        $note = ClientNote::findOrFail($id);
        $note->delete();

        return back()->with('success', 'Note deleted successfully.');
    }

    /**
     * Reply to a client query
     */
    public function replyToQuery(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $query = ClientQuery::findOrFail($id);
        $query->update([
            'admin_reply' => $request->reply,
            'status' => 'resolved',
        ]);

        return back()->with('success', 'Reply sent to client.');
    }
}
