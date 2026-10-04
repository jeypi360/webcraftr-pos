<?= view('templates/header', ['title' => 'Edit Product']) ?>

<h1>Edit Product</h1>
<p>Update the product details or replace its image.</p>

<?php if (session()->getFlashdata('errors')): ?>
    <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <p role="alert" style="color: #a00"><?= esc($error) ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (! empty($product['image'])): ?>
    <p>
        <strong>Current Image</strong><br>
        <img
            src="<?= base_url('uploads/products/' . rawurlencode($product['image'])) ?>"
            alt="<?= esc($product['name'], 'attr') ?>"
            width="160"
            height="160"
            style="object-fit: contain"
        >
    </p>
<?php endif; ?>

<form
    action="<?= site_url('products/' . $product['id']) ?>"
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
            value="<?= esc(old('name') ?? $product['name'], 'attr') ?>"
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
            value="<?= esc(old('price') ?? $product['price'], 'attr') ?>"
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
            value="<?= esc(old('stock_quantity') ?? $product['stock_quantity'], 'attr') ?>"
        >
    </p>

    <p>
        <label for="image">Replace Product Image (optional)</label><br>
        <input
            id="image"
            name="image"
            type="file"
            accept="image/jpeg,image/png,image/webp"
        ><br>
        <small>Leave empty to keep the image. JPG, PNG, or WebP; maximum 2 MB.</small>
    </p>

    <p>
        <button class="button" type="submit">Save Changes</button>
        <a class="button" href="<?= site_url('products') ?>">Cancel</a>
    </p>
</form>

<?= view('templates/footer') ?>