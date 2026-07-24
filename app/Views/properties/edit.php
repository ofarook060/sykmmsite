<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <style>
        @import url('https://googleapis.com');
        
        body { font-family: 'Noto Sans Myanmar', sans-serif; margin: 0; padding: 20px; background: #F8F6EE; line-height: 1.6; }
        .form-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #F4D66D; box-sizing: border-box; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #032F2E; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 1rem; font-family: 'Noto Sans Myanmar', sans-serif; }
        input[type="text"]:focus, textarea:focus { border-color: #D4AF37; outline: none; box-shadow: 0 0 5px rgba(212, 175, 55, 0.3); }
        textarea { min-height: 100px; resize: vertical; }
        
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; font-size: 0.9rem; }
        .alert-danger ul { margin: 0; padding-left: 20px; }
        
        button { width: 100%; padding: 12px; background: #D4AF37; color: #032F2E; border: none; border-radius: 8px; font-size: 1rem; font-weight: bold; cursor: pointer; font-family: 'Noto Sans Myanmar', sans-serif; }
        button:hover { background: #A87C17; }
        h1 { margin-top: 0; color: #032F2E; font-family: 'Noto Serif Myanmar', serif; }
        
        .image-preview-container { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px; }
        .current-img { max-width: 100px; height: auto; border-radius: 6px; border: 1px solid #ddd; object-fit: cover; }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <div class="form-card">
        <h1>Edit Property</h1>

        <!-- 1. DISPLAY ERROR MESSAGES IF VALIDATION FAILS -->
        <?php if (session()->has('errors')): ?>
            <div class="alert-danger">
                <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <!-- 2. ROUTED SECURELY USING BASE_URL -->
        <form action="<?= base_url('properties/edit/' . $property['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <label>Title *</label>
            <input type="text" name="title" value="<?= old('title', $property['title']) ?>" required maxlength="255">

            <label>Location</label>
            <input type="text" name="location" value="<?= old('location', $property['location']) ?>" maxlength="255">

            <label>Size</label>
            <input type="text" name="size" value="<?= old('size', $property['size']) ?>" maxlength="255">

            <label>Price (e.g., ၁၅၀၀၀၀, ညှိနှိုင်း)</label>
            <input type="text" name="price" value="<?= old('price', $property['price']) ?>" maxlength="255">

            <label>Rooms</label>
            <input type="text" name="rooms" value="<?= old('rooms', $property['rooms']) ?>" maxlength="255">

            <label>Master Bedrooms</label>
            <input type="text" name="masterBedrooms" value="<?= old('masterBedrooms', $property['masterBedrooms']) ?>" maxlength="255">

            <label>Bedrooms</label>
            <input type="text" name="bedrooms" value="<?= old('bedrooms', $property['bedrooms']) ?>" maxlength="255">

            <label>Bathrooms</label>
            <input type="text" name="bathrooms" value="<?= old('bathrooms', $property['bathrooms']) ?>" maxlength="255">

            <label>Description</label>
            <textarea name="description"><?= old('description', $property['description']) ?></textarea>

            <label>Facebook Post Iframe URL</label>
            <input type="text" name="facebookPost" value="<?= old('facebookPost', $property['facebookPost']) ?>">

            <!-- 3. RENDER MULTIPLE CURRENT IMAGES IN A CONTAINER GRID -->
            <?php if (!empty($property['images'])): ?>
                <label>Current Images</label>
                <div class="image-preview-container">
                    <?php $images = json_decode($property['images'], true); ?>
                    <?php if (is_array($images)): ?>
                        <?php foreach ($images as $img): ?>
                            <img src="<?= base_url(esc($img)) ?>" class="current-img" alt="Current Image">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- 4. ALLOW ADDING MULTIPLE ADDITIONAL IMAGES -->
            <label>Add More Images</label>
            <input type="file" name="images[]" accept="image/*" multiple>

            <button type="submit">Update Property</button>
        </form>
    </div>
</body>
</html>
