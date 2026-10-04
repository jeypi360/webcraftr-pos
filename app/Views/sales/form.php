<?= view('templates/header', ['title' => 'Record Sale']) ?>
<h1>Record Sale</h1>
<?php foreach ($errors as $error): ?><p role="alert" style="color:#a00"><?= esc($error) ?></p><?php endforeach; ?>
<form action="<?= site_url('sales') ?>" method="post">
    <?= csrf_field() ?>
    <p><label for="product_id">Product *</label><br>
    <select id="product_id" name="product_id" required>
        <option value="">Choose a product</option>
        <?php foreach ($products as $product): ?>
            <option value="<?= esc($product['id'], 'attr') ?>" <?= (string) ($values['product_id'] ?? '') === (string) $product['id'] ? 'selected' : '' ?>><?= esc($product['name']) ?> — ₱<?= number_format((float) $product['price'], 2) ?> (<?= esc($product['stock_quantity']) ?> in stock)</option>
        <?php endforeach; ?>
    </select></p>
    <p><label for="customer_id">Customer (optional)</label><br>
    <select id="customer_id" name="customer_id"><option value="">Walk-in customer</option>
        <?php foreach ($customers as $customer): ?>
            <option value="<?= esc($customer['id'], 'attr') ?>" <?= (string) ($values['customer_id'] ?? '') === (string) $customer['id'] ? 'selected' : '' ?>><?= esc($customer['full_name']) ?></option>
        <?php endforeach; ?>
    </select></p>
    <p><label for="quantity">Quantity *</label><br><input id="quantity" type="number" name="quantity" min="1" step="1" required value="<?= esc($values['quantity'] ?? '1', 'attr') ?>"></p>
    <button class="button" type="submit">Record Sale</button> <a class="button" href="<?= site_url('sales') ?>">Cancel</a>
</form>
<?= view('templates/footer') ?>
