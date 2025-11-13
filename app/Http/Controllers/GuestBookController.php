<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    /**
     * Simpan visitor message
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        GuestBook::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'approved' => false,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas pesan Anda!');
    }
}
