<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($post['title']) ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@400;700&family=Noto+Serif+Myanmar:wght@400;700&display=swap');
        
        body {
            font-family: 'Noto Sans Myanmar', sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1, h2, h3 {
            font-family: 'Noto Serif Myanmar', serif;
        }
        .post-content {
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            body { margin: 10px; }
        }

        /* --- CAROUSEL STYLES --- */
        .carousel-container { position: relative; max-width: 100%; height: 450px; margin: 20px 0 25px 0; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); background: #000; }
        .carousel-slide { display: none; width: 100%; height: 100%; }
        .carousel-slide img { width: 100%; height: 100%; object-fit: contain; }
        
        .carousel-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(3, 47, 46, 0.7); color: #fff; border: none; padding: 12px 16px; font-size: 18px; font-weight: bold; cursor: pointer; border-radius: 50%; transition: background 0.3s; user-select: none; z-index: 10; }
        .carousel-btn:hover { background: rgba(212, 175, 55, 0.9); color: #032F2E; }
        .prev { left: 15px; }
        .next { right: 15px; }

        .carousel-dots { position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10; }
        .dot { width: 10px; height: 10px; background: rgba(255, 255, 255, 0.5); border-radius: 50%; cursor: pointer; transition: background 0.3s; }
        .dot.active { background: #D4AF37; width: 24px; border-radius: 5px; }

        @media (max-width: 768px) {
            .carousel-container { height: 280px; }
            .carousel-btn { padding: 8px 12px; font-size: 14px; }
        }
    </style>
</head>
<body><?= view('partials/header') ?>
    <a href="/posts">&larr; Back to Posts</a>
    <h1><?= esc($post['title']) ?></h1>

    <?php
        $attachments = [];
        if (!empty($post['images'])) {
            $decoded = json_decode($post['images'], true);
            if (is_array($decoded)) {
                $attachments = $decoded;
            } else {
                $attachments = [
                    [
                        'path' => $post['images'],
                        'name' => basename($post['images']),
                    ],
                ];
            }
        }
    ?>

    <?php if (!empty($attachments)): ?>
        <?php $imageAttachments = array_values(array_filter($attachments, function ($attachment) {
            $path = is_string($attachment) ? $attachment : ($attachment['path'] ?? '');
            return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path);
        })); ?>

        <?php if (!empty($imageAttachments)): ?>
            <div class="carousel-container">
                <?php foreach ($imageAttachments as $index => $img): ?>
                    <?php $path = is_string($img) ? $img : ($img['path'] ?? ''); ?>
                    <div class="carousel-slide">
                        <img src="<?= base_url(esc($path)) ?>" alt="Blog Image <?= $index + 1 ?>">
                    </div>
                <?php endforeach; ?>

                <?php if (count($imageAttachments) > 1): ?>
                    <button class="carousel-btn prev" onclick="moveSlide(-1)">&#10094;</button>
                    <button class="carousel-btn next" onclick="moveSlide(1)">&#10095;</button>

                    <div class="carousel-dots">
                        <?php foreach ($imageAttachments as $index => $img): ?>
                            <span class="dot" onclick="setSlide(<?= $index ?>)"></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php $downloadAttachments = array_values(array_filter($attachments, function ($attachment) {
            $path = is_string($attachment) ? $attachment : ($attachment['path'] ?? '');
            return !preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path);
        })); ?>

        <?php if (!empty($downloadAttachments)): ?>
            <div style="margin: 20px 0;">
                <h3>Downloads</h3>
                <ul>
                    <?php foreach ($downloadAttachments as $attachment): ?>
                        <?php $path = is_string($attachment) ? $attachment : ($attachment['path'] ?? ''); ?>
                        <?php $name = is_string($attachment) ? basename($attachment) : ($attachment['name'] ?? basename($path)); ?>
                        <?php if (!empty($path)): ?>
                            <li><a href="<?= base_url(esc($path)) ?>" download><?= esc($name) ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="post-content">
        <p><?= nl2br(esc($post['content'])) ?></p>
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
