<?php
$current  = "Themes";
require_once 'header.php';
?>
<div class = "cell">
    <h2>Themes</h2>
</div>
<div class = "cell">
        <div class = "grid-x grid-padding-x">
                <?php
            if(isset($_GET['activate_theme']) && file_exists('../themes/'.$_GET['activate_theme'])){
                themeWrite($_GET['activate_theme']);
            }
                    $array = glob('../themes/*', GLOB_ONLYDIR);
                    for($i = 0; $i < count($array); $i++){
                        if(file_exists($array[$i]."/screenshot.png")){
                ?>
                <div class = "small-12 medium-6 large-4 cell">
                    <?php 
                            $theme_name = explode('/', $array[$i])[2];
                            $d = false;
                            if(themeUrl($theme_name)){
                                $d = true;
                            }
                    ?>
                    <div class ="theme-screenshot <?php if($d)  echo 'is-active-theme'; ?>">
                        <img src = "<?php echo $array[$i];?>/screenshot.png" class = "screenshot-thumbnail" title = "<?php echo $array[$i];?>/screenshot.png">
                        <span class = "theme-name"><?php  echo $theme_name;?></span>
                        <div class = "screenshot-activate-container clearfix">
                            
                            <?php if(!$d) { ?><a href = "?activate_theme=<?php echo $theme_name;?>" class = "button primary float-left">Activate</a><?php } ?>
                            <a href = "<?php echo WEBSITE_URL;?>?theme_preview=<?php echo $theme_name; ?>" class = "button primary float-right">Preview</a>
                        </div>
                    </div>
                    </div>
                <?php
                        }
                    }
                ?>
        </div>
</div>

            <?php
require_once 'footer.php';
?>