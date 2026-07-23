<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class PublicAreaController extends Controller
{
    public function index()
    {
        $areas = Area::latest()->get();
        return view('public.area', compact('areas'));
    }
}
