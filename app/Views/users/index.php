<?= view('templates/header', ['title' => 'User Accounts']) ?>

<h1>User Accounts</h1>

<p>List of user records retrieved from the database:</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Created At</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['id']) ?></td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>