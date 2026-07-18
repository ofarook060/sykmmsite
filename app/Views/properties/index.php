<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Noto+Serif+Myanmar:wght@400;700&display=swap');
    
    body {
        font-family: 'Noto Sans Myanmar', sans-serif;
    }
    h1, h2, h3 {
        font-family: 'Noto Serif Myanmar', serif;
    }
</style>

<body>
    <?= view('partials/header') ?>
    <main style="padding: 20px;">
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
    </main>
</body>

