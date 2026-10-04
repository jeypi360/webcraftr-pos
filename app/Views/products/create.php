<?= view('templates/header', ['title' => 'Add Product']) ?>

<h1>Add Product</h1>
<p>Enter the details below to add a product to your catalog.</p>

<?php if (session()->getFlashdata('errors')): ?>
    <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <p role="alert" style="color: #a00"><?= esc($error) ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form
    action="<?= site_url('products') ?>"
    method="post"
    enctype="multipart/form-data"
>
    <?= csrf_field() ?>

    <p>
        <label for="name">Product Name *</label><br>
        <input
            id="name"
            name="name"
            type="text"
            maxlength="100"
            required
            value="<?= esc(old('name') ?? '', 'attr') ?>"
        >
    </p>

    <p>
        <label for="price">Price (₱) *</label><br>
        <input
            id="price"
            name="price"
            type="number"
            step="0.01"
            min="0"
            required
            value="<?= esc(old('price') ?? '', 'attr') ?>"
        >
    </p>

    <p>
        <label for="stock_quantity">Stock Quantity *</label><br>
        <input
            id="stock_quantity"
            name="stock_quantity"
            type="number"
            step="1"
            min="0"
            required
            value="<?= esc(old('stock_quantity') ?? '', 'attr') ?>"
        >
    </p>

    <p>
        <label for="image">Product Image (optional)</label><br>
        <input
            id="image"
            name="image"
            type="file"
            accept="image/jpeg,image/png,image/webp"
        ><br>
        <small>JPG, PNG, or WebP; maximum 2 MB. Images are prepared for display.</small>
    </p>

    <p>
        <button class="button" type="submit">Save Product</button>
        <a class="button" href="<?= site_url('products') ?>">Cancel</a>
    </p>
</form>

<?= view('templates/footer') ?>