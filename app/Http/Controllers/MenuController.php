<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Validation\Rule;

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
	    'nama_menu'    => 'required|string|max:255',
	    'kategori'     => 'required|in:makanan,minuman',
	    'sub_kategori' => [
	        'required',
	        'string',
	        Rule::in($request->kategori === 'makanan'
	            ? ['snack', 'mie', 'makanan_berat', 'roti_bakar']
	            : ['signature_coffee', 'flavor_latte', 'manual_brew', 'soda', 'spresso_mixology', 'artisan_tea_mixology', 'espresso_based', 'non_coffee', 'milk_based']
	        ),
	    ],
	    'harga'      => 'required|numeric|min:0',
	    'tipe_suhu'  => 'required|in:panas,dingin,netral',
	    'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
	    'status'     => 'required|in:tersedia,habis,musiman',
	]);
    //logika penyimpanan gambar
    $pathFoto = null;
    if($request->hasFile('foto')){
    	// Simpan gambar ke folder 'storage/app/public/foto_menu
    	$pathFoto = $request->file('foto')->store('foto_menu', 'public');
    }
    

    Menu::create([
    	'nama_menu'=> $request->nama_menu,
    	'kategori' => $request->kategori,
    	'sub_kategori' => $request->sub_kategori,
    	'harga' => $request->harga,
    	'tipe_suhu' => $request->tipe_suhu,
    	'foto' => $pathFoto,
    	'status' =>$request->status,
    ]);
     return redirect()->route('admin.menu.index')->with('success', 'Menu Baru Berhasil Ditambahkan');

}
	public function destroy($id)
	{
	    $menu = Menu::findOrFail($id);
	    if ($menu->foto) {
	        \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->foto);
	    }
	    $menu->delete();
	    return redirect()->route('admin.menu.index')->with('success', 'Menu Berhasil Dihapus');
	}

	public function update(Request $request, $id)
	{
		$request->validate([
	    'nama_menu'    => 'required|string|max:255',
	    'kategori'     => 'required|in:makanan,minuman',
	    'sub_kategori' => [
	        'required',
	        'string',
	        Rule::in($request->kategori === 'makanan'
	            ? ['snack', 'mie', 'makanan_berat', 'roti_bakar']
	            : ['signature_coffee', 'flavor_latte', 'manual_brew', 'soda', 'spresso_mixology', 'artisan_tea_mixology', 'espresso_based', 'non_coffee', 'milk_based']
	        ),
	    ],
	    'harga'      => 'required|numeric|min:0',
	    'tipe_suhu'  => 'required|in:panas,dingin,netral',
	    'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
	    'status'     => 'required|in:tersedia,habis,musiman',
	]);

		//cari data menu berdasarkan id
		$menu = Menu::findOrFail($id);

		//jika ada foto baru
		if ($request->hasFile('foto')) {
			if($menu->foto){
				\Illuminate\Support\Facades\Storage::disk('public')->delete($menu->foto);
			}
			$menu->foto = $request->file('foto')->store('foto_menu', 'public');
		}
		$menu->update([
			'nama_menu' => $request->nama_menu,
			'kategori' => $request->kategori,
			'sub_kategori' =>$request->sub_kategori,
			'harga' => $request->harga,
			'tipe_suhu' => $request->tipe_suhu,
			'status' => $request->status,
		]);	
		return redirect()->route('admin.menu.index')->with('success', 'Data menu berhasil diupdate');
	}
}