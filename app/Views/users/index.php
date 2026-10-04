<?= view('templates/header', ['title' => 'Staff Accounts']) ?>

<h1>Staff Accounts</h1>

<a class="button" href="<?= site_url('users/new') ?>">
    New Staff
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
            <th>Avatar</th>
            <th>Username</th>
            <th>Name</th>
            <th>Created</th>
            <th class="actions-cell">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <img
                        src="<?= base_url(
                            'uploads/avatars/' .
                            (! empty($user['avatar'])
                                ? rawurlencode($user['avatar'])
                                : 'placeholder.svg')
                        ) ?>"
                        alt="Avatar for <?= esc($user['full_name'], 'attr') ?>"
                        width="64"
                        height="64"
                        style="object-fit: cover; border-radius: 50%"
                    >
                </td>

                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['created_at']) ?></td>

                <td class="actions-cell">
                    <a
                        class="button"
                        href="<?= site_url('users/' . $user['id'] . '/edit') ?>"
                    >
                        Edit
                    </a>

                    <?php if ((int) session('user_id') !== (int) $user['id']): ?>
                        <form
                            action="<?= site_url('users/' . $user['id'] . '/delete') ?>"
                            method="post"
                            style="display: inline"
                            onsubmit="return confirm('Delete this staff account?')"
                        >
                            <?= csrf_field() ?>
                            <button class="button" type="submit">
                                Delete
                            </button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>