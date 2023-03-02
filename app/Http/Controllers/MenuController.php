<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::whereNull('parent_id')->orderBy('order')->get();
        return view('layouts.app', ['menuItems' => $menuItems]);
    }
}
