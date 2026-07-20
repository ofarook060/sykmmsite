<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Noto+Serif+Myanmar:wght@400;700&display=swap');
        body { font-family: 'Noto Sans Myanmar', sans-serif; margin: 0; padding: 20px; background: #F8F6EE; }
        h1, h3 { font-family: 'Noto Serif Myanmar', serif; color: #032F2E; }
        .property-card { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #F4D66D; }
        .property-card img { width: 100%; max-width: 150px; height: auto; border-radius: 4px; margin-bottom: 10px; }
        .property-card p { margin: 5px 0; color: #555; }
        .property-card a { color: #D4AF37; text-decoration: none; font-weight: bold; }
        .property-card a:hover { text-decoration: underline; color: #A87C17; }
        @media (max-width: 480px) {
            body { padding: 10px; }
        }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <h1>Available Properties</h1>
    <?php foreach ($properties as $p): ?>
        <div class="property-card">
            <h3><?= esc($p['title']) ?></h3>
            <?php if (!empty($p['images'])): ?>
                <?php $images = json_decode($p['images'], true); ?>
                <?php if (is_array($images) && !empty($images)): ?>
                    <img src="<?= esc($images[0]) ?>" alt="Main Image">
                <?php endif; ?>
            <?php endif; ?>
            <p>Location: <?= esc($p['location'] ?? 'N/A') ?></p>
            <p>Price: $<?= esc(number_format((float) ($p['price'] ?? 0))) ?></p>
            <a href="/property/<?= $p['id'] ?>">View Details &rarr;</a>
        </div>
    <?php endforeach; ?>
</body>
</html>
