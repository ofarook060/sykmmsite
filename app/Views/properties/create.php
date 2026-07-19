<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Property</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #f4f6f9; }
        .form-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 1rem; }
        textarea { min-height: 100px; resize: vertical; }
        button { width: 100%; padding: 12px; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 1rem; font-weight: bold; cursor: pointer; }
        button:hover { background: #0056b3; }
        h1 { margin-top: 0; color: #333; }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <div class="form-card">
        <h1>Create Property</h1>
        <form action="/properties/create" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Title</label>
            <input type="text" name="title" placeholder="Property Title" required>
            <label>Location</label>
            <input type="text" name="location" placeholder="Location">
            <label>Size</label>
            <input type="text" name="size" placeholder="Size">
            <label>Price</label>
            <input type="text" name="price" placeholder="Price">
            <label>Rooms</label>
            <input type="text" name="rooms" placeholder="Rooms">
            <label>Master Bedrooms</label>
            <input type="text" name="masterBedrooms" placeholder="Master Bedrooms">
            <label>Bedrooms</label>
            <input type="text" name="bedrooms" placeholder="Bedrooms">
            <label>Bathrooms</label>
            <input type="text" name="bathrooms" placeholder="Bathrooms">
            <label>Description</label>
            <textarea name="description" placeholder="Description"></textarea>
            <label>Facebook Post URL</label>
            <input type="text" name="facebookPost" placeholder="Facebook Post URL">
            <label>Image</label>
            <input type="file" name="images" accept="image/*">
            <button type="submit">Save Property</button>
        </form>
    </div>
</body>
</html>
