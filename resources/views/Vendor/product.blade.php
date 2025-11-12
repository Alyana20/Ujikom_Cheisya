<h2>Tambah Produk</h2>

<form method="POST" action="{{ route('vendor.product.store') }}">
    @csrf

    <div>
        <label for="name">Nama Produk</label>
        <input id="name" type="text" name="name" required>
    </div>

    <div>
        <label for="price">Harga</label>
        <input id="price" type="number" name="price" step="0.01" required>
    </div>

    <div>
        <label for="stock">Stok</label>
        <input id="stock" type="number" name="stock" min="0" required>
    </div>

    <div>
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description"></textarea>
    </div>

    <button type="submit">Tambah Produk</button>
</form>
