<?= view('templates/header', ['title' => 'Home']) ?>

<h1>Welcome to the Basic POS System</h1>

<p>
    This website is the first version of a basic Point-of-Sale
    system developed using CodeIgniter 4.
</p>

<p>
    Use the navigation menu to view customer accounts,
    user accounts, and information about the system.
</p>

<a class="button" href="/customers">View Customers</a>

<?= view('templates/footer') ?>