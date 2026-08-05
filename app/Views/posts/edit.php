<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #F8F6EE; }
        .form-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #F4D66D; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #032F2E; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        textarea { min-height: 150px; resize: vertical; }
        button { width: 100%; padding: 12px; background: #D4AF37; color: #032F2E; border: none; border-radius: 8px; font-size: 1rem; font-weight: bold; cursor: pointer; }
        button:hover { background: #A87C17; }
        h1 { margin-top: 0; color: #032F2E; }
        .current-img { max-width: 100px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <div class="form-card">
        <h1>Edit Post</h1>
        <form action="/posts/edit/<?= $post['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Post Title</label>
            <input type="text" name="title" value="<?= esc($post['title']) ?>" required>
            <?php if ($post['images']): ?>
                <?php $attachments = json_decode($post['images'], true); ?>
                <label>Current Attachments</label>
                <ul style="margin-bottom: 15px; padding-left: 20px;">
                    <?php if (is_array($attachments)): ?>
                        <?php foreach ($attachments as $attachment): ?>
                            <?php $path = is_string($attachment) ? $attachment : ($attachment['path'] ?? ''); ?>
                            <?php $name = is_string($attachment) ? basename($attachment) : ($attachment['name'] ?? basename($path)); ?>
                            <?php if (!empty($path)): ?>
                                <li><a href="<?= base_url(esc($path)) ?>" download><?= esc($name) ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
            <label>Add More Files</label>
            <input type="file" name="files[]" multiple>
            <label>Content</label>
            <textarea name="content"><?= esc($post['content']) ?></textarea>
            <button type="submit">Update Post</button>
        </form>
    </div>
</body>
</html>
