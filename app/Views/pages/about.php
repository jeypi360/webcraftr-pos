<?= view('templates/header', ['title' => 'About']) ?>

<h1>About the System</h1>

<p>
    This basic Point-of-Sale website was developed using
    the CodeIgniter 4 framework.
</p>

<p>
    It consists of a landing page, an About page, a Customer
    Accounts page, and a User Accounts page.
</p>

<p>
    Customer and user records are currently stored in static
    PHP arrays. No database is used in this version.
</p>

<?= view('templates/footer') ?>