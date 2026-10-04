<?= view('templates/header', ['title' => 'Sales History']) ?>
<h1>Sales History</h1>
<p><a class="button" href="<?= site_url('sales/new') ?>">Record Sale</a></p>
<?php if (session()->getFlashdata('success')): ?><p role="status"><?= esc(session()->getFlashdata('success')) ?></p><?php endif; ?>
<?php if (! $sales): ?><p>No sales have been recorded yet.</p><?php else: ?>
<table><thead><tr><th>Product</th><th>Customer</th><th>Staff</th><th>Quantity</th><th>Total</th><th>Date</th></tr></thead><tbody>
<?php foreach ($sales as $sale): ?><tr>
    <td><?= esc($sale['product_name']) ?></td><td><?= esc($sale['customer_name'] ?: 'Walk-in') ?></td>
    <td><?= esc($sale['staff_name']) ?></td><td><?= esc($sale['quantity']) ?></td>
    <td>₱<?= number_format((float) $sale['total_price'], 2) ?></td><td><?= esc($sale['created_at']) ?></td>
</tr><?php endforeach; ?>
</tbody></table><?php endif; ?>
<?= view('templates/footer') ?>
