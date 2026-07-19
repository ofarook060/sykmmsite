<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Noto+Serif+Myanmar:wght@400;700&display=swap');
        body { font-family: 'Noto Sans Myanmar', sans-serif; margin: 0; padding: 20px; background: #f4f6f9; }
        h1, h2, h3 { font-family: 'Noto Serif Myanmar', serif; color: #333; }
        .post-item { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .post-item img { width: 100%; max-width: 300px; height: auto; border-radius: 4px; margin-bottom: 10px; }
        .post-item a { color: #007bff; text-decoration: none; font-weight: bold; }
        .post-item a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <h1>Latest Updates & News</h1>
    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (empty($posts)): ?>
        <p>No posts available yet.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-item">
                <h2><?= esc($post['title']) ?></h2>
                <?php if (!empty($post['images'])): ?>
                    <img src="<?= esc($post['images']) ?>" alt="Blog Image">
                <?php endif; ?>
                <p><?= character_limiter(esc($post['content']), 150) ?></p>
                <a href="/post/<?= $post['id'] ?>">Read Full Post &rarr;</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>

