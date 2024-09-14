<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserlistController extends Controller
{
    
public function index()
{
    $users = User::where('type', 'petugas')->get();
    return view('userlist.userlist', compact('users'));
}

public function search(Request $request)
{
    $search = $request->input('search');
    $users = User::where('type', 'petugas')
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', "%{$search}%");
                })
                ->get();

    return view('admin.userlist.index', compact('users'));
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.userlist.index')->with('success', 'Petugas deleted successfully');
}

public function toggleApproval($id)
{
    $user = User::findOrFail($id);
    $user->is_approved = !$user->is_approved;
    $user->save();

    return redirect()->back()->with('status', 'Approval status changed!');
}

}
