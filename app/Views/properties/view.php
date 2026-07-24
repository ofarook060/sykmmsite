<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($property) ? esc($property['title']) : 'Property Details' ?></title>
    <style>
        @import url('https://googleapis.com');
        
        body { font-family: 'Noto Sans Myanmar', sans-serif; line-height: 1.6; background-color: #F8F6EE; margin: 0; padding: 20px; }
        h1, h2, h3 { font-family: 'Noto Serif Myanmar', serif; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); box-sizing: border-box; border: 1px solid #F4D66D; }
        h1 { color: #032F2E; margin-top: 10px; }
        .price { font-size: 1.2em; color: #D4AF37; font-weight: bold; margin-bottom: 20px; }
        .details { background: #F8F6EE; padding: 15px; border-left: 4px solid #D4AF37; margin-bottom: 20px; border-radius: 0 8px 8px 0; }
        .btn { display: inline-block; background: #D4AF37; color: #032F2E; padding: 10px 15px; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .btn:hover { background: #A87C17; }
        .error { color: #dc3545; padding: 20px; text-align: center; }

        /* --- CAROUSEL STYLES --- */
        .carousel-container { position: relative; max-width: 100%; height: 450px; margin: 0 auto 25px auto; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); background: #000; }
        .carousel-slide { display: none; width: 100%; height: 100%; }
        .carousel-slide img { width: 100%; height: 100%; object-fit: cover; }
        
        .carousel-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(3, 47, 46, 0.7); color: #fff; border: none; padding: 12px 16px; font-size: 18px; font-weight: bold; cursor: pointer; border-radius: 50%; transition: background 0.3s; user-select: none; z-index: 10; }
        .carousel-btn:hover { background: rgba(212, 175, 55, 0.9); color: #032F2E; }
        .prev { left: 15px; }
        .next { right: 15px; }

        .carousel-dots { position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10; }
        .dot { width: 10px; height: 10px; background: rgba(255, 255, 255, 0.5); border-radius: 50%; cursor: pointer; transition: background 0.3s; }
        .dot.active { background: #D4AF37; width: 24px; border-radius: 5px; }

        @media (max-width: 768px) {
            body { padding: 10px; }
            .container { padding: 15px; }
            .carousel-container { height: 280px; }
            .carousel-btn { padding: 8px 12px; font-size: 14px; }
        }
    </style>
</head>
<body><?= view('partials/header') ?>

<div class="container">
    <?php if (isset($property) && !empty($property)): ?>
        
        <!-- IMAGE CAROUSEL SECTION -->
        <?php 
        $images = [];
        if (!empty($property['images'])) {
            $decoded = json_decode($property['images'], true);
            if (is_array($decoded)) {
                $images = $decoded;
            }
        }
        ?>

        <?php if (!empty($images)): ?>
            <div class="carousel-container">
                <?php foreach ($images as $index => $img): ?>
                    <div class="carousel-slide">
                        <img src="<?= base_url(esc($img)) ?>" alt="Property Image <?= $index + 1 ?>">
                    </div>
                <?php endforeach; ?>

                <!-- Hide navigational UI features if there's only 1 photo -->
                <?php if (count($images) > 1): ?>
                    <button class="carousel-btn prev" onclick="moveSlide(-1)">&#10094;</button>
                    <button class="carousel-btn next" onclick="moveSlide(1)">&#10095;</button>

                    <div class="carousel-dots">
                        <?php foreach ($images as $index => $img): ?>
                            <span class="dot" onclick="setSlide(<?= $index ?>)"></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <h1><?= esc($property['title']) ?></h1>
        
        <div class="price">
            Price: <?= !empty($property['price']) ? esc($property['price']) : 'Contact for Price' ?>
        </div>

        <div class="details">
            <p><strong>Location:</strong> <?= !empty($property['location']) ? esc($property['location']) : 'N/A' ?></p>
            <p><strong>Size:</strong> <?= !empty($property['size']) ? esc($property['size']) : 'N/A' ?></p>
            <p><strong>Total Rooms:</strong> <?= !empty($property['rooms']) ? esc($property['rooms']) : 'N/A' ?></p>
            <p><strong>Master Bedrooms:</strong> <?= !empty($property['masterBedrooms']) ? esc($property['masterBedrooms']) : 'N/A' ?></p>
            <p><strong>Bedrooms:</strong> <?= !empty($property['bedrooms']) ? esc($property['bedrooms']) : 'N/A' ?></p>
            <p><strong>Bathrooms:</strong> <?= !empty($property['bathrooms']) ? esc($property['bathrooms']) : 'N/A' ?></p>
        </div>

        <?php if (!empty($property['description'])): ?>
            <div class="description">
                <h3>Description</h3>
                <p><?= nl2br(esc($property['description'])) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($property['facebookPost'])): ?>
            <div class="facebook-post-container" style="margin-top: 20px;">
                <h3>Facebook Post</h3>
                <iframe 
                    src="<?= esc($property['facebookPost'], 'url'); ?>" 
                    width="500" 
                    height="700" 
                    style="border:none; overflow:hidden; width:100%; max-width:500px;" 
                    scrolling="no" 
                    frameborder="0" 
                    allowfullscreen="true" 
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                </iframe>
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

<!-- CAROUSEL INTERACTION ENGINE -->
<script>
    let slideIndex = 0;
    const slides = document.getElementsByClassName("carousel-slide");
    const dots = document.getElementsByClassName("dot");

    if (slides.length > 0) {
        showSlides(slideIndex);
    }

    function moveSlide(n) {
        showSlides(slideIndex += n);
    }

    function setSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        if (n >= slides.length) { slideIndex = 0; }
        if (n < 0) { slideIndex = slides.length - 1; }
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        
        slides[slideIndex].style.display = "block";
        if (dots.length > 0) {
            dots[slideIndex].className += " active";
        }
    }
</script>
</body>
</html>
