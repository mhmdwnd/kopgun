<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retail;
use Illuminate\Support\Facades\Storage;

class RetailController extends Controller
{
    public function index(){
    	$retails = \App\Models\Retail::all();
    	return view('admin.retail', compact('retails'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'nama_produk'	=>'required|string|max:255',
    		'harga'			=> 'required|numeric|min:0',
    		'detail_spesifik'=> 'nullable|string|max:255',
    		'foto'			=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    	]);

    	$pathFoto = null;
    	if($request->hasFile('foto')){
    		$pathFoto = $request->file('foto')->store('foto_retail', 'public');
    	}

    	Retail::create([
    		'nama_produk'	=> $request->nama_produk,
    		'harga'			=>$request->harga,
    		'detail_spesifik'=> $request->detail_spesifik,
    		'foto'			=>$pathFoto,
    	]);

    	return redirect()->route('admin.retail.index')->with('success', 'Produk berhasul ditambahkan');
    }

    public function update(Request $request, $id){
    	$request->validate([
    		'nama_produk'	=>'required|string|max:255',
    		'harga'			=> 'required|numeric|min:0',
    		'detail_spesifik'=> 'nullable|string|max:255',
    		'foto'			=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    	]);
    	$retail = Retail::findOrFail($id);

        // Jika ada unggahan foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($retail->foto) {
                Storage::disk('public')->delete($retail->foto);
            }
            // Simpan foto baru
            $retail->foto = $request->file('foto')->store('foto_retail', 'public');
        }
        $retail->update([
            'nama_produk'     => $request->nama_produk,
            'kategori'        => $request->kategori,
            'detail_spesifik' => $request->detail_spesifik,
            'harga'           => $request->harga,
            'stok'            => $request->stok,
        ]);
        return redirect()->route('admin.retail.index')->with('success', 'Produk berhasul diperbarui');
    }

    public function destroy($id){
    	$retail = Retail::findOrFail($id);
    	if ($retail->foto) {
    		Storage::disk('public')->delete($retail->foto);
    	}
    	$retail->delete();

    	return redirect()->route('admin.retail.index')->with('success', 'Data berhasil dihapus');
    }
}
