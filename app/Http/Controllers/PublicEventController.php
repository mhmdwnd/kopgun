<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class PublicEventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('public.event', compact('events'));
    }
}