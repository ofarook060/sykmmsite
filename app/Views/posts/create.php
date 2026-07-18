<!DOCTYPE html>
<html>
<head><title>Create Post</title></head>
<body><?= view("partials/header") ?>
    <h1>Create a New Post</h1>

    <form action="/posts/create" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Post Title</label><br>
        <input type="text" name="title" style="width:100%; max-width:500px;" required><br><br>

        <label>Featured Image</label><br>
        <input type="file" name="blog_image" accept="image/*"><br><br>

        <label>Content</label><br>
        <textarea name="content" rows="10" style="width:100%; max-width:500px;"></textarea><br><br>

        <button type="submit">Publish Post</button>
    </form>
</body>
</html>

