<!DOCTYPE html>
<html>
<head><title><?= esc($post['title']) ?></title></head>
<body>
    <a href="/posts">&larr; Back to Posts</a>
    <h1><?= esc($post['title']) ?></h1>

    <?php if (!empty($post['images'])): ?>
        <div style="margin: 20px 0;">
            <img src="/uploads/blog/<?= esc($post['images']) ?>" style="max-width:100%; height:auto;" alt="Blog Image">
        </div>
    <?php endif; ?>

    <div class="post-content">
        <p><?= nl2br(esc($post['content'])) ?></p>
    </div>
</body>
</html>

