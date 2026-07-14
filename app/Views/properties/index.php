<h1>Available Properties</h1>
<?php foreach ($properties as $p): ?>
    <div>
        <h3><?= esc($p['title']) ?></h3>
        <p>Location: <?= esc($p['location']) ?> | Price: <?= esc($p['price']) ?></p>

        <?php if (!empty($p['images'])): ?>
            <?php $images = json_decode($p['images'], true); ?>
            <img src="/uploads/<?= esc($images[0]) ?>" width="150" alt="Main Image">
        <?php endif; ?>

        <a href="/property/<?= $p['id'] ?>">View Details</a>
    </div>
    <hr>
<?php endforeach; ?>

