<?php
session_start();
require_once '../checkup.php';
require_once 'includes/function.php';

if(logged_in())
    header('location: index.php');

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href = "css/foundation.min.css">
        <link rel="stylesheet" href = "css/app.css">
        <link rel = "stylesheet" href = "../../font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href = "css/style.css"/>
    </head>
    
    <body>
        
        <div class = "grid-x grid-padding-x">
            <div class = "medium-2 large-3 cell"></div>
            <div class = "small-12 medium-8 large-6 cell ">
                <div class = "text-center cell"><img src = "img/logo.png" height="98px" width = "98px">
            <h3>Forgot/Reset Password</h3>
                </div>
            <div id = "reset">
                <p><?php echo messages();?></p>
                <form method = "post" action="">
                    <div class = "grid-x grid-padding-x">
                                <div class = "small-12 large-6 medium-6 cell">
                                    <label>
                                        Email/Username
                                    </label>
                                </div>
                           
                        <div class = "small-12 large-6 medium-6 cell">

                            <input type = "email" name = "username" value = "<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-25"></div>
                           <div class = "col-35">
                                <input type="submit" name="submit" class="submit" value="Reset" />  
                           </div>
                       <div class = "col-25"></div>
                    </div>      
                </form>
                <a href = "login.php">Go back to login</a>
            </div>
        </div>
            <div class = "medium-2 large-3 cell"></div>
        </div>
            <?php
                if(isset($_POST["submit"]) && $_POST['submit']){
                    resetPass($_POST['username']);
                    header('Location: '.$_SERVER['REQUEST_URI']);
                }
            ?>
    </body>
</html>