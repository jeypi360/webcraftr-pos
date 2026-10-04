<?= view('templates/header', ['title' => 'Customer Accounts']) ?>

<h1>Customer Accounts</h1>

<a class="button" href="<?= site_url('customers/new') ?>">
    New Customer
</a>

<?php if (session()->getFlashdata('success')): ?>
    <p role="status">
        <?= esc(session()->getFlashdata('success')) ?>
    </p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p role="alert" style="color: #a00">
        <?= esc(session()->getFlashdata('error')) ?>
    </p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created</th>
            <th class="actions-cell">Actions</th>
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

                <td class="actions-cell">
                    <a
                        class="button"
                        href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>"
                    >
                        Edit
                    </a>

                    <form
                        method="post"
                        action="<?= site_url('customers/' . $customer['id'] . '/delete') ?>"
                        style="display: inline"
                        onsubmit="return confirm('Delete this customer?')"
                    >
                        <?= csrf_field() ?>
                        <button class="button" type="submit">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>