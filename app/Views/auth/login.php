<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body { font-family: sans-serif; background: #F8F6EE; margin: 0; }
        .login-wrapper { display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 70px); padding: 20px; }
        .login-card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 350px; border: 1px solid #F4D66D; }
        h2 { margin-top: 0; text-align: center; color: #032F2E; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #032F2E; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background: #D4AF37; border: none; color: #032F2E; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .btn:hover { background: #A87C17; }
        .error { color: #dc3545; font-size: 0.9rem; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>
<?= view('partials/header') ?>
<div class="login-wrapper">
<div class="login-card">
    <h2>Admin Login</h2>

    <!-- Display Flash Error Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <form action="/login" method="post">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="admin-mySYK" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn">Login</button>
    </form>
</div>
</div>
</body>
</html>
