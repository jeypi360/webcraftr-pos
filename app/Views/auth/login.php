<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?> | Clothing POS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #9dc88d;
            color: #164a41;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: #ffffff;
            border: 2px solid #4d774e;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(22, 74, 65, 0.20);
        }

        h1 {
            margin: 0 0 8px;
            text-align: center;
            color: #164a41;
        }

        .subtitle {
            margin: 0 0 28px;
            text-align: center;
            color: #4d774e;
        }

        label {
            display: block;
            margin: 16px 0 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #9dc88d;
            border-radius: 6px;
            font-size: 16px;
        }

        input:focus {
            border-color: #164a41;
            outline: none;
            box-shadow: 0 0 0 3px rgba(22, 74, 65, 0.12);
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: 0;
            border-radius: 6px;
            background: #f1b24a;
            color: #164a41;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #d99a32;
        }

        .message {
            margin-bottom: 18px;
            padding: 12px;
            border-radius: 6px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .message ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <main class="login-card">
        <h1>Clothing POS</h1>
        <p class="subtitle">Staff Login</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="message error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="message success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php $errors = session()->getFlashdata('errors'); ?>

        <?php if ($errors): ?>
            <div class="message error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/login" method="post">
            <?= csrf_field() ?>

            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc(old('username')) ?>"
                autocomplete="username"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Log In</button>
        </form>
    </main>
</body>
</html>