<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Noto+Serif+Myanmar:wght@400;700&display=swap');
        body { font-family: 'Noto Sans Myanmar', sans-serif; margin: 0; padding: 20px; background: #F8F6EE; }
        h1, h2, h3 { font-family: 'Noto Serif Myanmar', serif; color: #032F2E; }
        .post-item { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #F4D66D; }
        .post-item img { width: 100%; max-width: 300px; height: auto; border-radius: 4px; margin-bottom: 10px; }
        .post-item a { color: #D4AF37; text-decoration: none; font-weight: bold; }
        .post-item a:hover { text-decoration: underline; color: #A87C17; }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <h1>Latest Updates & News</h1>
    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: #D4AF37;"><?= session()->getFlashdata('success') ?></p>
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
