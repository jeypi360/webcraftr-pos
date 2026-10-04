<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?> | Basic POS</title>

    <style>
        :root {
            --dark-green: #164A41;
            --medium-green: #4D774E;
            --light-green: #9DC88D;
            --gold-yellow: #F1B24A;
            --white: #FFFFFF;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--light-green);
            color: var(--dark-green);
        }

        nav {
            display: flex;
            align-items: center;
            gap: 25px;
            padding: 18px 8%;
            background: var(--dark-green);
        }

        .brand {
            margin-right: auto;
            color: var(--gold-yellow);
            font-size: 22px;
            font-weight: bold;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
        }

        nav a:hover {
            color: var(--gold-yellow);
        }

        .container {
            width: 90%;
            max-width: 1100px;
            min-height: 500px;
            margin: 40px auto;
            padding: 35px;
            background: var(--white);
            border: 2px solid var(--medium-green);
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(22, 74, 65, 0.25);
        }

        h1 {
            color: var(--dark-green);
        }

        .button {
            display: inline-block;
            min-width: 80px;
            margin-top: 15px;
            padding: 12px 20px;
            border: 0;
            border-radius: 5px;
            background: var(--gold-yellow);
            color: var(--dark-green);
            font-family: inherit;
            font-size: inherit;
            font-weight: bold;
            line-height: normal;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            color: var(--white);
            background: var(--medium-green);
        }

        .logout-button {
            min-width: 0;
            margin-top: 0;
            padding: 4px 9px;
            font-size: 13px;
        }

        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid var(--light-green);
            text-align: left;
        }

        th {
            color: var(--white);
            background: var(--medium-green);
        }

        tr:nth-child(even) {
            background: rgba(157, 200, 141, 0.25);
        }

        tr:hover {
            background: rgba(241, 178, 74, 0.20);
        }

        .actions-cell {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .actions-cell .button {
            margin-top: 0;
        }

        footer {
            padding: 20px;
            color: var(--dark-green);
            text-align: center;
        }
    </style>
</head>

<body>
    <nav>
        <span class="brand">POS</span>

        <?php if (session('isLoggedIn')): ?>
            <a href="<?= site_url('products') ?>">Products</a>
            <a href="<?= site_url('customers') ?>">Customers</a>
            <a href="<?= site_url('users') ?>">Staff</a>
            <a href="<?= site_url('sales/new') ?>">Record Sale</a>
            <a href="<?= site_url('sales') ?>">Sales History</a>

            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button class="button logout-button" type="submit">
                    Log Out
                </button>
            </form>
        <?php else: ?>
            <a href="<?= site_url('login') ?>">Log In</a>
        <?php endif; ?>
    </nav>

    <main class="container">