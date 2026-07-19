<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #f4f6f9; }
        .form-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 1rem; }
        textarea { min-height: 150px; resize: vertical; }
        button { width: 100%; padding: 12px; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 1rem; font-weight: bold; cursor: pointer; }
        button:hover { background: #0056b3; }
        h1 { margin-top: 0; color: #333; }
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
                <label>Current Image</label>
                <img src="<?= esc($post['images']) ?>" class="current-img" alt="Current Image">
            <?php endif; ?>
            <label>Replace Image</label>
            <input type="file" name="images" accept="image/*">
            <label>Content</label>
            <textarea name="content"><?= esc($post['content']) ?></textarea>
            <button type="submit">Update Post</button>
        </form>
    </div>
</body>
</html>
