<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SYK Services' ?></title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; color: #333; }
        header { display: flex; align-items: center; padding: 10px 20px; border-bottom: 1px solid #ddd; background: #fff; }
        .logo-title { display: flex; align-items: center; text-decoration: none; color: inherit; }
        .logo-title img { width: 40px; margin-right: 10px; }
        .logo-title h1 { margin: 0; font-size: 1.5rem; }
        main { padding: 20px; }
    </style>
</head>
<body><?= view("partials/header") ?>
    <header>
        <a href="/" class="logo-title">
            <img src="/logo.png" alt="Logo">
            <h1>SYK Services</h1>
        </a>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>
