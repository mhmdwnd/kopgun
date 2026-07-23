<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.event', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $fotoPath = $request->file('foto')->store('events', 'public');

        Event::create([
            'foto' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $event = Event::findOrFail($id);

        if ($request->hasFile('foto')) {
            if (Storage::disk('public')->exists($event->foto)) {
                Storage::disk('public')->delete($event->foto);
            }
            $event->foto = $request->file('foto')->store('events', 'public');
        }

        $event->deskripsi = $request->deskripsi;
        $event->save();

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if (Storage::disk('public')->exists($event->foto)) {
            Storage::disk('public')->delete($event->foto);
        }

        $event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil dihapus!');
    }
}