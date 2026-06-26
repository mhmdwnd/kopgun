<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uji Coba - Kelola Biji Kopi</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">

    <h1>Modul Uji Coba: Etalase Biji Kopi</h1>
    <a href="{{ route('admin.dashboard') }}">&larr; Kembali ke Dashboard</a>
    <hr>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd; margin-bottom: 20px; width: fit-content;">
        <h3>Tambah Biji Kopi Baru</h3>
        <form action="{{ route('admin.retail.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <p>
                <label>Nama Produk:</label><br>
                <input type="text" name="nama_produk" required placeholder="Contoh: Arabica Gayo 200gr">
            </p>

            <p>
                <label>Detail Spesifik (Opsional):</label><br>
                <input type="text" name="detail_spesifik" placeholder="Contoh: Medium Roast, Fruity">
            </p>

            <p>
                <label>Harga (Rp):</label><br>
                <input type="number" name="harga" required min="0">
            </p>

            <p>
                <label>Foto Produk:</label><br>
                <input type="file" name="foto" accept="image/*">
            </p>

            <button type="submit" style="padding: 5px 10px; cursor: pointer;">Simpan Produk</button>
        </form>
    </div>

    <h3>Daftar Biji Kopi Saat Ini</h3>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead style="background-color: #eee;">
            <tr>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Detail Spesifik</th>
                <th>Harga</th>
                <th>Aksi (Uji Coba Edit & Hapus)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($retails as $retail)
                <tr>
                    <td>
                        @if($retail->foto)
                            <img src="{{ asset('storage/' . $retail->foto) }}" alt="Foto" width="60" style="border: 1px solid #ccc;">
                        @else
                            <i>Tanpa Foto</i>
                        @endif
                    </td>
                    <td><strong>{{ $retail->nama_produk }}</strong></td>
                    <td>{{ $retail->detail_spesifik ?? '-' }}</td>
                    <td>Rp {{ number_format($retail->harga, 0, ',', '.') }}</td>
                    
                    <td>
                        <form action="{{ route('admin.retail.update', $retail->id) }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 10px; padding: 10px; border: 1px dashed gray; background-color: #fafafa;">
                            @csrf
                            @method('PUT')
                            <p style="margin-top: 0;"><b>Ubah Data:</b></p>
                            <input type="text" name="nama_produk" value="{{ $retail->nama_produk }}" required>
                            <input type="text" name="detail_spesifik" value="{{ $retail->detail_spesifik }}">
                            <input type="number" name="harga" value="{{ $retail->harga }}" required min="0">
                            <input type="file" name="foto" accept="image/*">
                            <button type="submit">Uji Update</button>
                        </form>

                        <form action="{{ route('admin.retail.destroy', $retail->id) }}" method="POST" onsubmit="return confirm('Hapus produk biji kopi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: red; cursor: pointer;">Hapus Produk</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: gray;">Belum ada data biji kopi. Silakan tambahkan di form atas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>