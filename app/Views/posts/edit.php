<!DOCTYPE html>
<html>
<head><title>Edit Post</title></head>
<body><?= view("partials/header") ?>
    <h1>Edit Post</h1>

    <form action="/posts/edit/<?= $post['id'] ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Post Title</label><br>
        <input type="text" name="title" value="<?= esc($post['title']) ?>" style="width:100%; max-width:500px;" required><br><br>

        <label>Featured Image</label><br>
        <?php if($post['images']): ?>
            <img src="<?= $post['images'] ?>" style="width:100px;"><br>
        <?php endif; ?>
        <input type="file" name="images" accept="image/*"><br><br>

        <label>Content</label><br>
        <textarea name="content" rows="10" style="width:100%; max-width:500px;"><?= esc($post['content']) ?></textarea><br><br>

        <button type="submit">Update Post</button>
    </form>
</body>
</html>
