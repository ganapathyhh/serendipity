<?php
session_start();
require_once 'checkup.php';

if(!is_installed())//Check whether installed
    header('location:admin/install.php');

if(!check_connection()) //Check for proper installation
    die('DATABASE CONNECTION FAILED');
include 'includes/functions.php';
?>
<?php
if(isset($_GET['p'])){
    init($_GET['p']);
    //header('Location: '.getPostSlug());
}

if(isset($_GET['theme_preview']))
    require_once themeUrl($_GET['theme_preview']).'index.php';
else
    require_once themeUrl()."index.php";
?>


