<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AdminIndex(){
        $totalProducts = Product::count();
        $totalUsers = User::count();

        return view('layouts.admin.home', compact('totalProducts', 'totalUsers'));
    } 

    public function PetugasIndex(){
        $totalProducts = Product::count();
        $totalUsers = User::count();

        return view('layouts.petugas.home', compact('totalProducts', 'totalUsers'));
    }
}
