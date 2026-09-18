<?= view('templates/header', ['title' => 'Customer Accounts']) ?>

<h1>Customer Accounts</h1>

<p>List of registered customer records retrieved from the database:</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Created At</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['id']) ?></td>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone']) ?></td>
                <td><?= esc($customer['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>