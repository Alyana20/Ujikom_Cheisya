<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class StoreController extends Controller
{
    public function create()
    {
        $store = Store::where('user_id', Auth::id())->first();
        return view('vendor.store.create', compact('store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Store::updateOrCreate(
            ['user_id' => Auth::id()],
            ['name' => $request->name, 'description' => $request->description]
        );

        return redirect()->route('vendor.dashboard')->with('success', 'Toko berhasil dibuat atau diperbarui!');
    }
}
