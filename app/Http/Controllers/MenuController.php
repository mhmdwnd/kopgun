<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
    	$menus = Menu::all();
    	return view('admin.menu', compact('menus'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    	'nama_menu'=> 'required|string|max:255',
    	'kategori' =>'required|in:makanan,minuman',
    	'harga' => 'required|numeric|min:0',
    	'tipe_suhu' => 'required|in:panas,dingin,netral',
    	'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);
    //logika penyimpanan gambar
    $pathfoto = null;
    if($request->hasFile('foto')){
    	// Simpan gambar ke folder 'storage/app/public/foto_menu
    	$pathFoto = $request->file('foto')->store('foto_menu', 'public');
    }
    

    Menu::create([
    	'nama_menu'=> $request->nama_menu,
    	'kategori' => $request->kategori,
    	'harga' => $request->harga,
    	'tipe_suhu' => $request->tipe_suhu,
    	'foto' => $pathFoto,
    ]);
     return redirect()->back()->with('succes', 'Menu Baru Berhasil Ditambahkan');

}
	public function destroy($id)
	{
		$menu = Menu::findOrFail($id);
		$menu->delete();

		return redirect()->back()->with('success', 'Menu Berhasil Dihapus');
	}
}