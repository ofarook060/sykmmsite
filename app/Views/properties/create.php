<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Property</title>
    <style>
        @import url('https://googleapis.com');
        
        body { font-family: 'Noto Sans Myanmar', sans-serif; line-height: 1.6; background-color: #F8F6EE; margin: 0; padding: 20px; }
        h1 { font-family: 'Noto Serif Myanmar', serif; color: #032F2E; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); box-sizing: border-box; border: 1px solid #F4D66D; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #032F2E; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; font-family: 'Noto Sans Myanmar', sans-serif; font-size: 14px; }
        .form-control:focus { border-color: #D4AF37; outline: none; box-shadow: 0 0 5px rgba(212, 175, 55, 0.5); }
        
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
        .alert-danger ul { margin: 0; padding-left: 20px; }
        
        .btn { display: inline-block; background: #D4AF37; color: #032F2E; padding: 12px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #A87C17; }
        .btn-secondary { background: #ccc; color: #333; margin-left: 10px; }
        .btn-secondary:hover { background: #bbb; }
    </style>
</head>
<body><?= view('partials/header') ?>

<div class="container">
    <h1>Add New Property</h1>

    <!-- Display Validation Errors if any exist -->
    <?php if (session()->has('errors')): ?>
        <div class="alert-danger">
            <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= base_url('properties/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="title">Property Title *</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= old('title') ?>" required maxlength="255">
        </div>

        <div class="form-group">
            <label for="price">Price (e.g., ၁၅၀၀၀၀, 150000, ညှိနှိုင်း)</label>
            <input type="text" name="price" id="price" class="form-control" value="<?= old('price') ?>" maxlength="255">
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="<?= old('location') ?>" maxlength="255">
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" name="size" id="size" class="form-control" value="<?= old('size') ?>" maxlength="255">
        </div>

        <div class="form-group">
            <label for="rooms">Total Rooms</label>
            <input type="text" name="rooms" id="rooms" class="form-control" value="<?= old('rooms') ?>" maxlength="255">
        </div>

        <div class="form-group">
            <label for="masterBedrooms">Master Bedrooms</label>
            <input type="text" name="masterBedrooms" id="masterBedrooms" class="form-control" value="<?= old('masterBedrooms') ?>" maxlength="255">
        </div>

        <div class="form-group">
            <label for="bedrooms">Bedrooms</label>
            <input type="text" name="bedrooms" id="bedrooms" class="form-control" value="<?= old('bedrooms') ?>" maxlength="255">
        </div>

        <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <input type="text" name="bathrooms" id="bathrooms" class="form-control" value="<?= old('bathrooms') ?>" maxlength="255">
        </div>

        <div class="form-group">
            <label for="facebookPost">Facebook Post Iframe Source URL</label>
            <input type="url" name="facebookPost" id="facebookPost" class="form-control" value="<?= old('facebookPost') ?>" placeholder="https://facebook.com?...">
        </div>

        <div class="form-group">
            <label for="images">Upload Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="5" class="form-control"><?= old('description') ?></textarea>
        </div>

        <button type="submit" class="btn">Save Property</button>
        <a href="<?= base_url('properties') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
