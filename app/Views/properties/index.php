<style>
    @font-face {
        font-family: 'Pyidaungsu';
        src: url('https://cdn.jsdelivr.net/npm/pyidaungsu@1.0.3/fonts/Pyidaungsu-2.5_Regular.woff2') format('woff2');
    }
    body {
        font-family: 'Pyidaungsu', sans-serif;
    }
</style>

<h1>Available Properties</h1>
<?php foreach ($properties as $p): ?>
    <div>
        <h3><?= esc($p['title']) ?></h3>
        <p>Location: <?= esc($p['location']) ?> | Price: <?= esc($p['price']) ?></p>

        <?php if (!empty($p['images'])): ?>
            <?php $images = json_decode($p['images'], true); ?>
            <?php if (is_array($images) && !empty($images)): ?>
                <img src="<?= esc($images[0]) ?>" width="150" alt="Main Image">
            <?php endif; ?>
        <?php endif; ?>

        <a href="/property/<?= $p['id'] ?>">View Details</a>
    </div>
    <hr>
<?php endforeach; ?>

