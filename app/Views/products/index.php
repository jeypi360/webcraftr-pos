<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | Clothing POS</title>
</head>
<body>
    <h1>Products</h1>

    <p>Welcome, <?= esc(session('full_name')) ?>!</p>

    <p>
        <a href="/products/create">Add Product</a>
    </p>

    <form action="/logout" method="post">
        <?= csrf_field() ?>
        <button type="submit">Log Out</button>
    </form>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;">
            <?= esc(session()->getFlashdata('success')) ?>
        </p>
    <?php endif; ?>

    <hr>

    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php if (! empty($product['image'])): ?>
                                <img
                                    src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                    alt="<?= esc($product['name']) ?>"
                                    width="80"
                                >
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td><?= esc($product['id']) ?></td>
                        <td><?= esc($product['name']) ?></td>
                        <td>₱<?= number_format((float) $product['price'], 2) ?></td>
                        <td><?= esc($product['stock_quantity']) ?></td>
                        <td>
                            <a href="/products/<?= esc($product['id']) ?>/edit">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>