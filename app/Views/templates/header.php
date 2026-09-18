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
            margin-top: 15px;
            padding: 12px 20px;
            color: var(--dark-green);
            font-weight: bold;
            text-decoration: none;
            background: var(--gold-yellow);
            border-radius: 5px;
        }

        .button:hover {
            color: var(--white);
            background: var(--medium-green);
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

        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/customers">Customers</a>
        <a href="/users">Users</a>
    </nav>

    <main class="container">