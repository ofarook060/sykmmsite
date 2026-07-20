<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #F8F6EE; }
        .form-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #F4D66D; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #032F2E; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        textarea { min-height: 100px; resize: vertical; }
        button { width: 100%; padding: 12px; background: #D4AF37; color: #032F2E; border: none; border-radius: 8px; font-size: 1rem; font-weight: bold; cursor: pointer; }
        button:hover { background: #A87C17; }
        h1 { margin-top: 0; color: #032F2E; }
        .current-img { max-width: 100px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <div class="form-card">
        <h1>Edit Property</h1>
        <form action="/properties/edit/<?= $property['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Title</label>
            <input type="text" name="title" value="<?= esc($property['title']) ?>" required>
            <label>Location</label>
            <input type="text" name="location" value="<?= esc($property['location']) ?>">
            <label>Size</label>
            <input type="text" name="size" value="<?= esc($property['size']) ?>">
            <label>Price</label>
            <input type="text" name="price" value="<?= esc($property['price']) ?>">
            <label>Rooms</label>
            <input type="text" name="rooms" value="<?= esc($property['rooms']) ?>">
            <label>Master Bedrooms</label>
            <input type="text" name="masterBedrooms" value="<?= esc($property['masterBedrooms']) ?>">
            <label>Bedrooms</label>
            <input type="text" name="bedrooms" value="<?= esc($property['bedrooms']) ?>">
            <label>Bathrooms</label>
            <input type="text" name="bathrooms" value="<?= esc($property['bathrooms']) ?>">
            <label>Description</label>
            <textarea name="description"><?= esc($property['description']) ?></textarea>
            <label>Facebook Post URL</label>
            <input type="text" name="facebookPost" value="<?= esc($property['facebookPost']) ?>">
            <?php if ($property['images']): ?>
                <label>Current Image</label>
                <?php $images = json_decode($property['images']); ?>
                <?php if (is_array($images)): ?>
                    <?php foreach ($images as $img): ?>
                        <img src="<?= esc($img) ?>" class="current-img" alt="Current Image">
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
            <label>Replace Image</label>
            <input type="file" name="images" accept="image/*">
            <button type="submit">Update Property</button>
        </form>
    </div>
</body>
</html>
