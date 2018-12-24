<!doctype HTML>

<html>
<head>
    <meta charset="utf-8"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,700i&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="/accets/css/main.css" type="text/css" media="all" />
    <title><?= \engine\classes\Translate::t('site', 'signup_form_title') ?></title>
</head>
<body>
<div class="wrapper">
    <header class="header">
        <nav class="header__navbar">
            <?php if (empty($_SESSION['auth'])): ?>
                <div class="header__navbar-item">
                    <a href="/" class="header__navbar-link"><?= \engine\classes\Translate::t('site', 'sign_up') ?></a>
                </div>
            <?php else: ?>
                <div class="header__navbar-item">
                    <a href="/logout" class="header__navbar-link"><?= \engine\classes\Translate::t('site', 'log_out') ?></a>
                </div>
            <?php endif; ?>
            <div class="header__navbar-item">
                <span class="header__navbar-link"><?= strtoupper($_SESSION['lang']) ?></span>
                <div class="header__navbar-subnavbar hidden">
                    <?php if ($_SESSION['lang'] == 'en'): ?>
                    <a href="/setlang?lang=ru" class="header__navbar-subnavbar-link">RU</a>
                    <?php else: ?>
                    <a href="/setlang?lang=en" class="header__navbar-subnavbar-link">EN</a>
                    <?php endif ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="container">
        <div class="content">
            <?= $content ?>
        </div>
    </main>
</div>

<script src="/localize.js" type="text/javascript"></script>
<script src="/accets/js/main.js"></script>
</body>
</html>