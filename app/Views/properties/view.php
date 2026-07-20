<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($property) ? esc($property['title']) : 'Property Details' ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Noto+Serif+Myanmar:wght@400;700&display=swap');
        
        body { font-family: 'Noto Sans Myanmar', sans-serif; line-height: 1.6; background-color: #F8F6EE; margin: 0; padding: 20px; }
        h1, h2, h3 { font-family: 'Noto Serif Myanmar', serif; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); box-sizing: border-box; border: 1px solid #F4D66D; }
        h1 { color: #032F2E; }
        .price { font-size: 1.2em; color: #D4AF37; font-weight: bold; margin-bottom: 20px; }
        .details { background: #F8F6EE; padding: 15px; border-left: 4px solid #D4AF37; margin-bottom: 20px; border-radius: 0 8px 8px 0; }
        .btn { display: inline-block; background: #D4AF37; color: #032F2E; padding: 10px 15px; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .btn:hover { background: #A87C17; }
        .error { color: #dc3545; padding: 20px; text-align: center; }
        @media (max-width: 768px) {
            body { padding: 10px; }
            .container { padding: 15px; }
        }
    </style>
</head>
<body><?= view('partials/header') ?>

<div class="container">
    <?php if (isset($property) && !empty($property)): ?>
        <h1><?= esc($property['title']) ?></h1>
        
        <div class="price">
            Price: <?= esc(number_format((float) $property['price'], 2)) ?>
        </div>

        <div class="details">
            <p><strong>Location:</strong> <?= esc($property['location'] ?? 'N/A') ?></p>
            <p><strong>Size:</strong> <?= esc($property['size'] ?? 'N/A') ?></p>
            <p><strong>Rooms:</strong> <?= esc($property['rooms'] ?? 'N/A') ?></p>
            <p><strong>Bedrooms:</strong> <?= esc($property['bedrooms'] ?? 'N/A') ?></p>
            <p><strong>Bathrooms:</strong> <?= esc($property['bathrooms'] ?? 'N/A') ?></p>
        </div>

        <div class="description">
            <h3>Description</h3>
            <p><?= nl2br(esc($property['description'])) ?></p>
        </div>

        <?php if (!empty($property['facebookPost'])): ?>
            <div class="facebook-post">
                <h3>Facebook Post</h3>
                <a href="<?= esc($property['facebookPost']) ?>" target="_blank">View on Facebook</a>
            </div>
        <?php endif; ?>

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
