<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($property) ? esc($property['title']) : 'Property Details' ?></title>
    <style>
        @font-face {
            font-family: 'Pyidaungsu';
            src: url('https://cdn.jsdelivr.net/npm/pyidaungsu@1.0.3/fonts/Pyidaungsu-2.5_Regular.woff2') format('woff2');
        }
        body { font-family: 'Pyidaungsu', sans-serif; line-height: 1.6; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .price { font-size: 1.2em; color: #2ecc71; font-weight: bold; margin-bottom: 20px; }
        .details { background: #f9f9f9; padding: 15px; border-left: 4px solid #3498db; margin-bottom: 20px; }
        .btn { display: inline-block; background: #3498db; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 3px; }
        .btn:hover { background: #2980b9; }
        .error { color: #e74c3c; padding: 20px; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($property) && !empty($property)): ?>
        <h1><?= esc($property['title']) ?></h1>
        
        <div class="price">
            Price: $<?= esc(number_format((float)$property['price'], 2)) ?>
        </div>

        <div class="details">
            <p><strong>Location:</strong> <?= esc($property['location'] ?? 'N/A') ?></p>
            <p><strong>Type:</strong> <?= esc($property['type'] ?? 'N/A') ?></p>
            <p><strong>Status:</strong> <?= esc($property['status'] ?? 'Available') ?></p>
        </div>

        <div class="description">
            <h3>Description</h3>
            <p><?= nl2br(esc($property['description'])) ?></p>
        </div>

        <br>
        <a href="<?= base_url('properties') ?>" class="btn">&larr; Back to Properties</a>
    <?php else: ?>
        <div class="error">
            <h2>Property Not Found</h2>
            <p>The requested property details could not be loaded.</p>
            <a href="<?= base_url('properties') ?>" class="btn">Back to Directory</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

