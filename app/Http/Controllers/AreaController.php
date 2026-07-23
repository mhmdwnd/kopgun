<?php
namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::latest()->get();
        return view('admin.area', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $fotoPath = $request->file('foto')->store('areas', 'public');

        Area::create([
            'foto' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.area.index')->with('success', 'Area berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $area = Area::findOrFail($id);

        if ($request->hasFile('foto')) {
            if (Storage::disk('public')->exists($area->foto)) {
                Storage::disk('public')->delete($area->foto);
            }
            $area->foto = $request->file('foto')->store('areas', 'public');
        }

        $area->deskripsi = $request->deskripsi;
        $area->save();

        return redirect()->route('admin.area.index')->with('success', 'Area berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);

        if (Storage::disk('public')->exists($area->foto)) {
            Storage::disk('public')->delete($area->foto);
        }

        $area->delete();

        return redirect()->route('admin.area.index')->with('success', 'Area berhasil dihapus!');
    }
}