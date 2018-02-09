<?php
$current = "Settings";
require_once 'header.php';
?>
<div class = "cell">
    <h3>Settings</h3>
</div>
<div class = "cell">
    <?php echo messages(); ?>
    <?php 
        if(isset($_POST['save-settings'])){
            GetDashboardData::saveSettings($_POST['site-title'], $_POST['site-description'], $_POST['site-address'], $_POST['email-address'], $_POST['meta-data'], $_POST['hit-score'], $_POST['like-score'], $_POST['dislike-score']);
            header('location: '.$_SERVER['REQUEST_URI']);
        }
    ?>
    <form action = "" method="post">
        <div class = "grid-x grid-padding-x">
            <div class = "small-12 large-6 cell">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Site Title</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" name = "site-title" placeholder="Site Title" autocomplete="off" value="<?php echo WEBSITE_TITLE; ?>">
                    </div>
                </div>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Site Address</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" name = "site-address" placeholder="Site URL" autocomplete="off" value = "<?php echo WEBSITE_URL; ?>">
                    </div>
                </div>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Email Address</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" name = "email-address" placeholder="Email" autocomplete="off" value = "<?php echo ADMIN_EMAIL; ?>">
                    </div>
                </div>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Site Meta</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <textarea name = "meta-data" placeholder="Meta Data" autocomplete="off"><?php if(defined('SITE_META')) echo SITE_META; ?></textarea>
                    </div>
                </div>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Site Description</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <textarea name = "site-description" placeholder="Site Description" autocomplete="off" rows = "6"><?php if(defined('SITE_DESCR')) echo SITE_DESCR; ?></textarea>
                    </div>
                </div>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Default Hits Score</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" name = "hit-score" placeholder = "Enter hits score" value = "<?php if(defined('SITE_HIT')) echo SITE_HIT; else echo '0'; ?>">
                    </div>
                </div>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Default Likes Score</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" name = "like-score" placeholder = "Enter likes score" value = "<?php if(defined('SITE_LIKE')) echo SITE_LIKE; else echo '0'; ?>">
                    </div>
                </div>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Default Dislikes Score</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" name = "dislike-score" placeholder = "Enter dislikes score" value = "<?php if(defined('SITE_DISLIKE')) echo SITE_DISLIKE; else echo '0'; ?>">
                    </div>
                </div>
               
                <input type = "submit" class = "button" value = "Save Changes" name = "save-settings">
            </div>
        </div>
    </form>
</div>
<?php

require_once 'footer.php';
?>