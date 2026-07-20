<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #F8F6EE; }
        .form-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #F4D66D; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #032F2E; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        textarea { min-height: 150px; resize: vertical; }
        button { width: 100%; padding: 12px; background: #D4AF37; color: #032F2E; border: none; border-radius: 8px; font-size: 1rem; font-weight: bold; cursor: pointer; }
        button:hover { background: #A87C17; }
        h1 { margin-top: 0; color: #032F2E; }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <div class="form-card">
        <h1>Create a New Post</h1>
        <form action="/posts/create" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Post Title</label>
            <input type="text" name="title" placeholder="Post title" required>
            <label>Featured Image</label>
            <input type="file" name="blog_image" accept="image/*">
            <label>Content</label>
            <textarea name="content" placeholder="Write your post content here..."></textarea>
            <button type="submit">Publish Post</button>
        </form>
    </div>
</body>
</html>
