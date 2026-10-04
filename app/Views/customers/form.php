<?= view('templates/header', ['title' => isset($customer['id']) ? 'Edit Customer' : 'New Customer']) ?>
<?php $editing = isset($customer['id']); ?>
<h1><?= $editing ? 'Edit Customer' : 'New Customer' ?></h1>
<form action="<?= site_url($editing ? 'customers/' . $customer['id'] : 'customers') ?>" method="post">
    <?= csrf_field() ?>
    <p><label for="full_name">Full Name *</label><br><input id="full_name" name="full_name" required maxlength="100" value="<?= esc($customer['full_name'] ?? '', 'attr') ?>"></p>
    <?php if (isset($errors['full_name'])): ?><p style="color:#a00"><?= esc($errors['full_name']) ?></p><?php endif; ?>
    <p><label for="email">Email *</label><br><input id="email" type="email" name="email" required maxlength="100" value="<?= esc($customer['email'] ?? '', 'attr') ?>"></p>
    <?php if (isset($errors['email'])): ?><p style="color:#a00"><?= esc($errors['email']) ?></p><?php endif; ?>
    <p><label for="phone">Phone</label><br><input id="phone" type="tel" name="phone" maxlength="20" value="<?= esc($customer['phone'] ?? '', 'attr') ?>"></p>
    <?php if (isset($errors['phone'])): ?><p style="color:#a00"><?= esc($errors['phone']) ?></p><?php endif; ?>
    <p><button class="button" type="submit"><?= $editing ? 'Save Changes' : 'Create Customer' ?></button> <a class="button" href="<?= site_url('customers') ?>">Cancel</a></p>
</form>
<?= view('templates/footer') ?>
