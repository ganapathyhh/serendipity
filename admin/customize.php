<?php
$current = "Customize";
require_once 'header.php';
?>
<div class = "cell">
    <h3>Customize</h3>
</div>
<div class = "cell">
    <div class = "grid-x grid-margin-x">
        <?php 
            $themeDir =  isset($_SESSION['theme-name'])?$_SESSION['theme-name']:themeName();
            if(isset($_POST['theme-select'])){
                $_SESSION['theme-name'] = $_POST['theme-name'];
                header('location:'.$_SERVER['REQUEST_URI']);
            }
                
                $array = glob('../themes/*', GLOB_ONLYDIR);
            ?>
        <?php
            $themeDirectory = '../themes/'.$themeDir.'/';
                    function listFolderFiles($dir){
                        $allowed = array('php', 'html', 'css');
                        $contents = array();
                        foreach(scandir($dir) as $file){
                            if($file == '.' || $file == '..') continue;
                            $path = $dir.DIRECTORY_SEPARATOR.$file;
                            if(is_dir($path)){
                                $contents = array_merge($contents, listFolderFiles($path));
                            } else {
                                if(in_array(pathinfo($file, PATHINFO_EXTENSION), $allowed))
                                    $contents[$file] = $path;
                            }
                        }
                        return $contents;
                    }
                    $dirFileArr = array();
                    $contentFiles = listFolderFiles($themeDirectory);
                    $first_key = key($contentFiles);
        
                    if(isset($_POST['update-file'])){
                        $fileName = '';
                        if(isset($_GET['file_getter']))
                           $fileName = $_GET['file_getter'];
                        else{
                            $temp = explode('/', $contentFiles[0]);
                            $temp = explode('\\', $temp);
                           $fileName = $temp[count($temp) - 1];
                        }
                        file_put_contents($themeDirectory.$fileName, $_POST['custom-content']);
                        header('location: '.$_SERVER['REQUEST_URI']);
                    }
        ?>
        <div class = "small-12 medium-10 cell small-order-2">
            <form action = "" method = "post">
                <textarea class = "customise-content" name = "custom-content"><?php if(isset($_GET['file_getter'])) echo file_get_contents($contentFiles[$_GET['file_getter']]); else echo file_get_contents($contentFiles[$first_key]); ?></textarea>
                <input type = "submit" class = "button primary" value = "Save" name = "update-file">
            </form>
        </div>
        <div class = "small-12 medium-2 cell small-order-1">
            
            <form action = "" method = "post">
                <select name = "theme-name">
                    <?php 
                        for($i = 0; $i < count($array); $i++){
                    ?>
                    
                    <option value = "<?php echo explode('/', $array[$i])[2]; ?>"  <?php if(explode('/', $array[$i])[2] == $themeDir) echo 'selected'; ?>><?php echo explode('/', $array[$i])[2]; ?></option>
                    <?php
                        }
                    ?>
                </select>
                <input type = "submit" name = "theme-select" class = "button primary" value = "Select">
                <h5>File to edit</h5>
                <?php
                    
                    foreach($contentFiles as $fileShow){
                        $counter = explode('/', $fileShow);
                        $counter = explode('\\', $fileShow);
                ?>
                    <a href = "?file_getter=<?php echo $counter[count($counter) - 1]; ?>" title = "<?php echo $counter[count($counter) - 1]; ?>" style = "font-size: 1.2em; display: block; line-height: 2em"><?php echo $counter[count($counter) - 1];?></a>
                <?php
                }
                ?>
            </form>
            
        </div>
    </div>
</div>

<?php

require_once 'footer.php';
?>