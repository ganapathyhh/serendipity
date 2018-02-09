<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo themeUrl(); ?>/css/foundation.min.css">
    <link rel="stylesheet" href="<?php echo themeUrl(); ?>/css/app.css">
    <?php getHeader(); ?>
    <title><?php echo getPostTItle(); ?></title>
</head>

<body>
    <div data-sticky-container>
        <div data-sticky data-margin-top class="top-bar">
            <div class="top-bar-left">
                <span class="tagline"><?php echo getSiteMeta(); ?></span>
            </div>
            <div class="top-bar-right">
                <ul class="dropdown menu" data-dropdown-menu>
                    <li class="menu-text"><?php echo getSiteTitle(); ?></li>
                    <li>
                        <a href="#">One</a>
                    </li>
                    <li><a href="#">Two</a></li>
                    <li><a href="#">Three</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="hero">
        <h1><span class="main-title"><?php echo getPostTitle(); ?></span></h1>
    </section>

    <section class="main-body">
        <div class="grid-x inner-body">
            <div class="small-3 cell sidebar">
                <h3>SIDEBAR</h3>
                <ul class="menu vertical">
                    <li><a href="#">One</a></li>
                    <li><a href="#">Two</a></li>
                    <li><a href="#">Three</a></li>
                </ul>

            </div>

            <div class="small-9 cell">
                <section class="main-content">
                    <?php echo getPostContent(); ?>
                </section>
            </div>

        </div>
    </section>

    <footer>
        
        <?php getWidgets(); ?>
        <p class="copyright">&copy; <?php echo getSiteTitle();  ?>,2018</p>
    </footer>


    <script src="<?php echo themeUrl(); ?>/js/vendor/jquery.js"></script>
    <script src="<?php echo themeUrl(); ?>/js/vendor/foundation.min.js"></script>
    <script src="<?php echo themeUrl(); ?>/js/app.js"></script>
    <?php getFooter(); ?>

</body>

</html>
