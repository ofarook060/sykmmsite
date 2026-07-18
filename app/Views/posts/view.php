<!DOCTYPE html>
<html>
<head>
    <title><?= esc($post['title']) ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Noto+Serif+Myanmar:wght@400;700&display=swap');
        
        body {
            font-family: 'Noto Sans Myanmar', sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1, h2, h3 {
            font-family: 'Noto Serif Myanmar', serif;
        }
        .post-content {
            margin-top: 20px;
        }
    </style>
</head>
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

