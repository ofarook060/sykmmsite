<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        @media (max-width: 768px) {
            body { margin: 10px; }
        }
    </style>
</head>
<body><?= view('partials/header') ?>
    <a href="/posts">&larr; Back to Posts</a>
    <h1><?= esc($post['title']) ?></h1>

    <?php
        $attachments = [];
        if (!empty($post['images'])) {
            $decoded = json_decode($post['images'], true);
            if (is_array($decoded)) {
                $attachments = $decoded;
            } else {
                $attachments = [
                    [
                        'path' => $post['images'],
                        'name' => basename($post['images']),
                    ],
                ];
            }
        }
    ?>

    <?php if (!empty($attachments)): ?>
        <?php $imageAttachments = array_filter($attachments, function ($attachment) {
            $path = is_string($attachment) ? $attachment : ($attachment['path'] ?? '');
            return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path);
        }); ?>

        <?php if (!empty($imageAttachments)): ?>
            <div style="margin: 20px 0;">
                <?php $firstImage = is_string(reset($imageAttachments)) ? reset($imageAttachments) : (reset($imageAttachments)['path'] ?? ''); ?>
                <?php if (!empty($firstImage)): ?>
                    <img src="<?= esc($firstImage) ?>" style="max-width:100%; height:auto;" alt="Blog Image">
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php $downloadAttachments = array_filter($attachments, function ($attachment) {
            $path = is_string($attachment) ? $attachment : ($attachment['path'] ?? '');
            return !preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path);
        }); ?>

        <?php if (!empty($downloadAttachments)): ?>
            <div style="margin: 20px 0;">
                <h3>Downloads</h3>
                <ul>
                    <?php foreach ($downloadAttachments as $attachment): ?>
                        <?php $path = is_string($attachment) ? $attachment : ($attachment['path'] ?? ''); ?>
                        <?php $name = is_string($attachment) ? basename($attachment) : ($attachment['name'] ?? basename($path)); ?>
                        <?php if (!empty($path)): ?>
                            <li><a href="<?= base_url(esc($path)) ?>" download><?= esc($name) ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="post-content">
        <p><?= nl2br(esc($post['content'])) ?></p>
    </div>
</body>
</html>

