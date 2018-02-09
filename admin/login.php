<?php
session_start();
require_once '../checkup.php';
require_once 'includes/function.php';

/**
*Checks whether the product is installed or not
*
*If negative, redirects to the install page
*/

if(!is_installed()){
    header('Location: install.php');
}

/**
*Checks whether the user has logged in
*
*If logged in, the page will be redirected to index
*/

if(logged_in())
    header('location: index.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login - Serendipity</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href = "css/foundation.min.css">
        <link rel="stylesheet" href = "css/app.css">
        <link rel = "stylesheet" href = "../../font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href = "css/style.css"/>
    </head>
    
    <body>
        
            <div class="grid-x grid-padding-x align-middle">
                <div class = "large-3 cell"></div>
                <div class = "large-6 cell">
                    <div class = "text-center">
                        <img src = "img/logo.png" height="98px" width = "98px">
                        <h3>Serendipity Login</h3>
                        <p><?php echo messages();?></p> 
                    </div>
                     
                    <?php 
                        if(isset($_POST["submit"]) && $_POST['submit']) {
                            login($_POST['username'], $_POST['password']);
                            header('Location:'.$_SERVER['REQUEST_URI']);
                        }
                    ?>
                    <div id = "login">
                        
                       <form method="post" action="">
                           <div class = "grid-x grid-padding-x">
                                <div class = "small-12 large-6 medium-6 cell">
                                    <label>
                                        Email/Username
                                    </label>
                                </div>
                               
                                <div class = "small-12 large-6 medium-6 cell">
                                    <input type="text" name="username" placeholder=  'Username/Email' autocomplete = "off"/>
                               </div>
                           <div class = "small-12 medium-6 large-6 cell">
                                   <label>Password</label>
                               </div>
                               <div class = "small-12 medium-6 large-6 cell">
                                    <input type="password" name="password"  placeholder = "Password" autocomplete = "off"/>
                               </div>
                           </div>
                            <div class = "row">
                                <a href = "reset.php">Forgot password</a>
                           </div>
                            <div class = "row">
                                        <input type="submit" name="submit" class="submit" value="Login" />  
                            </div>                     
                        </form>
                    </div>
                </div>
                <div class = "large-3 cell"></div>
            </div>
        <script src = "js/jquery.min.js"></script>
        <script src="js/vendor/foundation.min.js"></script>
        <script src = "js/app.js"></script>
    </body>
</html>