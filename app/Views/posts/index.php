<!DOCTYPE html>
<html>
<head><title>Blog Posts</title></head>
<body>
    <h1>Latest Updates & News</h1>
    
    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if (empty($posts)): ?>
        <p>No posts available yet.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-item" style="margin-bottom: 30px;">
                <h2><?= esc($post['title']) ?></h2>

                <?php if (!empty($post['images'])): ?>
                    <img src="/uploads/blog/<?= esc($post['images']) ?>" width="300" alt="Blog Image"><br>
                <?php endif; ?>

                <p><?= character_limiter(esc($post['content']), 150) ?></p>
                <a href="/post/<?= $post['id'] ?>">Read Full Post &rarr;</a>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>

