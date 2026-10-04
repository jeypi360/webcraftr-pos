<?= view('templates/header', ['title' => isset($user['id']) && $user['id'] !== null ? 'Edit Staff' : 'New Staff']) ?>
<?php $editing = isset($user['id']) && $user['id'] !== null; ?>
<h1><?= $editing ? 'Edit Staff' : 'New Staff' ?></h1>
<form method="post" action="<?= site_url($editing ? 'users/' . $user['id'] : 'users') ?>" enctype="multipart/form-data">
<?= csrf_field() ?>
<p><label for="username">Username *</label><br><input id="username" name="username" required maxlength="50" value="<?= esc($user['username'] ?? '', 'attr') ?>"></p>
<?php if (isset($errors['username'])): ?><p style="color:#a00"><?= esc($errors['username']) ?></p><?php endif; ?>
<p><label for="full_name">Full Name *</label><br><input id="full_name" name="full_name" required maxlength="100" value="<?= esc($user['full_name'] ?? '', 'attr') ?>"></p>
<?php if (isset($errors['full_name'])): ?><p style="color:#a00"><?= esc($errors['full_name']) ?></p><?php endif; ?>
<p><label for="password">Password <?= $editing ? '(leave blank to keep current password)' : '*' ?></label><br><input id="password" name="password" type="password" minlength="8" <?= $editing ? '' : 'required' ?> autocomplete="new-password"></p>
<?php if (isset($errors['password'])): ?><p style="color:#a00"><?= esc($errors['password']) ?></p><?php endif; ?>
<?php if ($editing): ?>
<p><img src="<?= base_url('uploads/avatars/' . (! empty($user['avatar']) ? rawurlencode($user['avatar']) : 'placeholder.svg')) ?>" alt="Current avatar" width="80" height="80" style="object-fit:cover;border-radius:50%"></p>
<?php endif; ?>
<p><label for="avatar">Avatar (JPG or PNG, max 2MB)</label><br><input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png"></p>
<?php if (isset($errors['avatar'])): ?><p style="color:#a00"><?= esc($errors['avatar']) ?></p><?php endif; ?>
<p><button class="button" type="submit"><?= $editing ? 'Save Changes' : 'Create Staff' ?></button> <a class="button" href="<?= site_url('users') ?>">Cancel</a></p>
</form>
<?= view('templates/footer') ?>
