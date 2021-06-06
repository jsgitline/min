<?php
/**
 * @var array $context
 * @var string $template
 */
$templates = SITE_PATH . DS . 'FirstApp' . DS . 'Templates' . DS;
$defaultTitle = 'Заголовок поумолчанию';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if(isset($context['title']) && !empty($context['title'])): ?>

        <title><?= $context['title'] ?></title>

    <?php else: ?>

        <title><?= $defaultTitle ?></title>

    <?php endif; ?>
    <link rel="stylesheet" href="/public/css/normalize.css">
    <link rel="stylesheet" href="/public/css/ui.css?v=3">
    <link rel="stylesheet" href="/public/css/ui-responsive.css?v=1">
    <link rel="stylesheet" href="/public/css/site.css?v=2">

    <link rel="apple-touch-icon" sizes="57x57" href="/public/img/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/public/img/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/public/img/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/public/img/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/public/img/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/public/img/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/public/img/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/public/img/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/img/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/public/img/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/public/img/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/img/icons/favicon-16x16.png">
    <link rel="manifest" href="/public/img/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/public/img/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('sw.js?v=22', { scope: '/' }).then(
                    function(registration) {
                        // Registration was successful
                        console.log('ServiceWorker registration successful with scope: ', registration.scope); },
                    function(err) {
                        // registration failed :(
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
</head>
<body>
<div id="preloader">
    <div id="preload"></div>
</div>
<style>
    #preloader>p{display:none;}
    #preload{display: block;position: fixed;z-index: 99999;top: 0;left: 0;width: 100%;height: 100%;min-width: 1000px;background: #fff;background-size:41px;}
</style>

<script type="text/javascript">
    let hellopreloader = document.getElementById("preload");
    function fadeOutnojquery(el){el.style.opacity = 1;
        var interhellopreloader = setInterval(function() {
            el.style.opacity = el.style.opacity - 0.07;if (el.style.opacity <=0.07){
                clearInterval(interhellopreloader);hellopreloader.style.display = "none";
            }
        },16);
    }window.onload = function(){
        setTimeout(function(){fadeOutnojquery(hellopreloader);},300);
    };

</script>
<?php
if(isset($template) && !empty($template)){
    require_once $templates . $template;
} else{
    echo 'Шаблона нет';
}
?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</body>
</html>