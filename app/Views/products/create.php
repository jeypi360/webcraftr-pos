<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | Clothing POS</title>
</head>
<body>
    <h1>Add Product</h1>

    <p><a href="/products">← Back to Products</a></p>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="color: #b00020;">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/products" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <p>
            <label for="name">Product Name</label><br>
            <input
                type="text"
                id="name"
                name="name"
                value="<?= esc(old('name')) ?>"
                required
            >
        </p>

        <p>
            <label for="price">Price (₱)</label><br>
            <input
                type="number"
                id="price"
                name="price"
                value="<?= esc(old('price')) ?>"
                step="0.01"
                min="0"
                required
            >
        </p>

        <p>
            <label for="stock_quantity">Stock Quantity</label><br>
            <input
                type="number"
                id="stock_quantity"
                name="stock_quantity"
                value="<?= esc(old('stock_quantity')) ?>"
                min="0"
                required
            >
        </p>

        <p>
            <label for="image">Product Image (optional)</label><br>
            <input
                type="file"
                id="image"
                name="image"
                accept=".jpg,.jpeg,.png,.webp"
            ><br>
            <small>JPG, JPEG, PNG, or WebP only; maximum 2 MB.</small>
        </p>

        <button type="submit">Save Product</button>
    </form>
</body>
</html>