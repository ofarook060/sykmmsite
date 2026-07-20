<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYK Real Estate Services</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #F8F6EE; color: #333; }
        header { background: #032F2E; box-shadow: 0 2px 5px rgba(0,0,0,0.15); padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; color: #D4AF37; text-decoration: none; }
        nav a { margin-left: 20px; text-decoration: none; color: #fff; font-weight: 500; }
        nav a:hover { color: #D4AF37; }

        .hero { background: linear-gradient(135deg, #032F2E, #0C4440); padding: 80px 20px; text-align: center; color: white; }
        .hero h1 { margin-0; font-size: 2.5rem; color: #D4AF37; }

        .search-container { max-width: 800px; margin: -30px auto 40px auto; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .search-form { display: flex; gap: 15px; flex-wrap: wrap; }
        .search-form input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; min-width: 200px; }
        .search-form button { padding: 12px 25px; background: #D4AF37; color: #032F2E; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer; font-weight: bold; }
        .search-form button:hover { background: #A87C17; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .section-title { text-align: center; margin: 40px 0 20px 0; font-size: 2rem; position: relative; color: #032F2E; }
        .section-title::after { content: ''; display: block; width: 50px; height: 3px; background: #D4AF37; margin: 10px auto 0 auto; }

        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-bottom: 50px; }
        .card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform 0.2s; display: flex; flex-direction: column; border: 1px solid #F4D66D; }
        .card:hover { transform: translateY(-5px); }
        .card-img { width: 100%; height: 200px; object-fit: cover; background: #e9ecef; }
        .card-body { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
        .card-title { font-size: 1.25rem; margin: 0 0 10px 0; color: #032F2E; }
        .card-price { font-size: 1.4rem; color: #D4AF37; font-weight: bold; margin-bottom: 10px; }
        .card-meta { font-size: 0.9rem; color: #666; margin-bottom: 15px; }
        .card-text { font-size: 0.95rem; color: #555; line-height: 1.5; margin-bottom: 15px; }
        .btn-view { display: block; text-align: center; padding: 10px; background: #F8F6EE; color: #D4AF37; border: 1px solid #D4AF37; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: auto; }
        .btn-view:hover { background: #D4AF37; color: #032F2E; }

        footer { background: #032F2E; color: white; text-align: center; padding: 20px; margin-top: 50px; font-size: 0.9rem; }
        @media (max-width: 768px) {
            .hero { padding: 50px 15px; }
            .hero h1 { font-size: 1.6rem; }
            .search-container { margin: -20px 15px 30px 15px; padding: 15px; }
            .search-form input { min-width: 0; flex: 1 1 100%; }
            .search-form button { width: 100%; }
            .container { padding: 0 15px; }
            .section-title { font-size: 1.5rem; }
            .grid { grid-template-columns: 1fr; gap: 20px; }
        }
    </style>
</head>
<body>

    <?= view('partials/header') ?>


    <div class="hero">
        <h1>Find Your Perfect Dynamic Living Space</h1>
        <p>Explore premium real estate listings and insightful articles</p>
    </div>

    <!-- Live Filter Component Box -->
    <div class="search-container">
        <form action="/" method="get" class="search-form">
            <input type="text" name="location" placeholder="Search by location (e.g. City)..." value="<?= esc($old_location) ?>">
            <input type="number" name="price" placeholder="Maximum Price ($)..." value="<?= esc($old_price) ?>">
            <button type="submit">Filter Listings</button>
            <?php if (!empty($old_location) || !empty($old_price)): ?>
                <a href="/" style="padding:12px; color:#dc3545; text-decoration:none;">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="container">

        <!-- Properties Section -->
        <h2 class="section-title">Featured Properties</h2>
        <div class="grid">
            <?php if (empty($properties)): ?>
                <p style="text-align: center; grid-column: 1/-1; color: #666;">No properties match your current search.</p>
            <?php else: ?>
                <?php foreach ($properties as $prop): ?>
                    <div class="card">
                        <?php
                        $images = json_decode($prop['images'] ?? '', true);
                    $imgSrc = (!empty($images) && is_array($images)) ? $images[0] : '';
                    ?>
                        <img src="<?= esc($imgSrc) ?>" class="card-img" alt="Property Image">
                        <div class="card-body">
                            <h3 class="card-title"><?= esc($prop['title']) ?></h3>
                            <div class="card-price">$<?= esc(number_format((float) ($prop['price'] ?? 0))) ?></div>
                            <div class="card-meta">📍 <?= esc($prop['location'] ?? 'Unknown Location') ?></div>
                            <a href="/property/<?= $prop['id'] ?>" class="btn-view">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Blog/Posts Section -->
        <h2 class="section-title">Latest Articles & Updates</h2>
        <div class="grid">
            <?php if (empty($latest_posts)): ?>
                <p style="text-align: center; grid-column: 1/-1; color: #666;">No blog posts available yet.</p>
            <?php else: ?>
                <?php foreach ($latest_posts as $post): ?>
                    <div class="card">
                        <?php
                    $imgSrc = !empty($post['images']) ? $post['images'] : '';
                    ?>
                        <img src="<?= esc($imgSrc) ?>" class="card-img" alt="Blog Image">
                        <div class="card-body">
                            <h3 class="card-title"><?= esc($post['title']) ?></h3>
                            <p class="card-text"><?= esc(character_limiter($post['content'] ?? '', 100)) ?></p>
                            <a href="/post/<?= $post['id'] ?>" class="btn-view">Read Post</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

    <footer>
        <p>&copy; <?= date('Y') ?> SYK Services. Built with CodeIgniter 4.</p>
    </footer>

</body>
</html>
