<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook - SYK Services</title>
    <style>
        @import url('https://googleapis.com');

        body { font-family: 'Noto Sans Myanmar', sans-serif; margin: 0; padding: 20px; background: #F8F6EE; line-height: 1.6; }
        h1 { font-family: 'Noto Serif Myanmar', serif; color: #032F2E; text-align: center; margin-bottom: 10px; }
        .subtitle { text-align: center; color: #555; margin-bottom: 30px; }
        .container { max-width: 500px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); box-sizing: border-box; border: 1px solid #F4D66D; }
        .fb-page-wrapper { display: flex; justify-content: center; width: 100%; }
        .fb-page-wrapper .fb-page { width: 100% !important; }
        .btn { display: inline-block; background: #D4AF37; color: #032F2E; padding: 10px 15px; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .btn:hover { background: #A87C17; }
        .back-link { text-align: center; margin-top: 20px; }
        @media (max-width: 540px) {
            body { padding: 10px; }
            .container { padding: 10px; }
        }
    </style>
</head>
<body><?= view('partials/header') ?>

<div class="container">
    <h1>Follow Us on Facebook</h1>
    <p class="subtitle">Stay updated with our latest properties and news</p>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v22.0"></script>

    <div class="fb-page-wrapper">
        <div class="fb-page"
             data-href="https://www.facebook.com/sykrestate"
             data-tabs="timeline"
             data-width=""
             data-height="800"
             data-small-header="false"
             data-adapt-container-width="true"
             data-hide-cover="false"
             data-show-facepile="true">
        </div>
    </div>

    <div class="back-link">
        <a href="/" class="btn">&larr; Back to Home</a>
    </div>
</div>

</body>
</html>
