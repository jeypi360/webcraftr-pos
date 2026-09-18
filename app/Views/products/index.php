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

    <form action="/logout" method="post">
        <?= csrf_field() ?>
        <button type="submit">Log Out</button>
    </form>

    <hr>

    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= esc($product['id']) ?></td>
                        <td><?= esc($product['name']) ?></td>
                        <td>₱<?= number_format((float) $product['price'], 2) ?></td>
                        <td><?= esc($product['stock_quantity']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>