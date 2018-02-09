<?php
//error_reporting(0);
session_start();
require_once('../checkup.php');



if(!is_installed()){
?>
<html>
    <head>
        <title>Install - Serendipity - Page 1</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href = "css/foundation.min.css">
        <link rel="stylesheet" href = "css/app.css">
        <link rel = "stylesheet" href = "../../font-awesome/css/font-awesome.min.css">
        <link rel = "stylesheet" href="css/style.css"/>
    </head>
    <body>
        
        <div class="grid-x grid-padding-x">
            <div class = "large-3 cell"></div>
            <div class = "large-6 cell">
                <div class = "text-center">
                    <img src = "img/logo.png" height="98px" width = "98px"> 
                    <h3>Serendipity Installer</h3>
                    <p>Get these info from your webhost.</p>
                </div>
                    <form method = "post" name = "form" id = "form" action = "db_connect.php">

                        <?php //Database Hostname input ?>

                        <div class = "cell">
                            <div class = "grid-x grid-padding-x">
                                <div class = "small-8 medium-4 large-4 cell">
                                    <label>Database Hostname</label>
                                </div>

                                <div class = "small-4 medium-2 large-2 cell">
                                    <i class = "fa fa-info-circle has-tip middle" data-tooltip aria-haspopup="true" aria-hidden = "true" data-disable-hover="false" tabindex="1" title="Your webhost MySQL name." data-position="right" data-alignment="top"></i>
                                </div>

                                <div class = "small-12 medium-6 large-6 cell">
                                    <input type="text" placeholder="Hostname..." id = "hostname" autocomplete="off" name ="hostname" value = "localhost">
                                </div>
                            </div>
                        </div>

                        <?php //Database User name input ?>

                        <div class = "cell">
                            <div class = "grid-x grid-padding-x">
                                <div class = "small-8 medium-4 large-4 cell">
                                    <label>Database User Name </label>
                                </div>

                            <div class = "small-4 medium-2 large-2 cell">
                                <i class = "fa fa-info-circle has-tip middle" data-tooltip aria-haspopup="true" aria-hidden = "true" data-disable-hover="false" tabindex="1" title="Your webhost MySQL user name." data-position="right" data-alignment="top"></i>
                            </div>
                            <div class = "small-12 medium-6 large-6 cell">
                                <input type="text" id="username" name="username" placeholder="User Name..." value = "root" autocomplete="off">
                            </div>
                        </div>
                    </div>

                          <?php //Database Password input ?>
                        <div class = "cell">
                            <div class = "grid-x grid-padding-x">
                                <div class = "small-8 medium-4 large-4 cell">
                                    <label>Database Password</label>
                                </div>

                                <div class = "small-4 medium-2 large-2 cell">
                                    <i class = "fa fa-info-circle has-tip middle" data-tooltip aria-haspopup="true" aria-hidden = "true" data-disable-hover="false" tabindex="1" title="Your webhost MySQL password." data-position="right" data-alignment="top"></i>
                                </div>
                                <div class = "small-12 medium-6 large-6 cell">
                                    <input type="password" name = "password" id ="password" placeholder="Password" autocomplete="off">
                                </div>
                            </div>
                        </div>

                          <?php //Database Name input ?>

                        <div class = "cell">
                            <div class = "grid-x grid-padding-x">
                                <div class = "small-8 medium-4 large-4 cell">
                                    <label>Database Name </label>
                                </div>

                                <div class = "small-4 medium-2 large-2 cell">
                                    <i class = "fa fa-info-circle has-tip middle" data-tooltip aria-haspopup="true" aria-hidden = "true" data-disable-hover="false" tabindex="1" title="Your webhost MySQL Database name." data-position="right" data-alignment="top"></i>
                                </div>

                                <div class = "small-12 medium-6 large-6 cell">
                                    <input type="text" name = "dbname" id ="dbname" placeholder="Database Name..." value = "serendipity" autocomplete="off">
                                </div>
                            </div>
                        </div>


                        <?php //Website Title input ?>

                        <div class = "cell">
                            <div class = "grid-x grid-padding-x">
                                <div class = "small-8 medium-4 large-4 cell">
                                    <label>Website Title </label>
                                </div>

                                    <div class = "small-4 medium-2 large-2 cell">
                                        <i class = "fa fa-info-circle has-tip middle" data-tooltip aria-haspopup="true" aria-hidden = "true" data-disable-hover="false" tabindex="1" title="Your website title." data-position="right" data-alignment="top"></i>
                                    </div>

                                    <div class = "small-12 medium-6 large-6 cell">
                                        <input type = "text" id="webname" name="websitename" placeholder = "Website name... " value = "" autocomplete= "off"/>
                                    </div>
                                </div>
                            </div>

                        <?php  //Admin Username input ?>

                            <div class = "cell">
                                <div class = "grid-x grid-padding-x">
                                    <div class = "small-8 medium-4 large-4 cell">                                
                                        <label>Admin Email </label>
                                    </div>

                                    <div class = "small-4 medium-2 large-2 cell">
                                        <i class = "fa fa-info-circle has-tip middle" data-tooltip aria-haspopup="true" aria-hidden = "true" data-disable-hover="false" tabindex="1" title="Your email." data-position="right" data-alignment="top"></i>
                                    </div>

                                    <div class = "small-12 medium-6 large-6 cell">
                                        <input type="text" name = "adminemail" id ="adminemail" placeholder="Admin Email..." value = "" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        <?php  //Admin Password input ?>

                        <div class = "cell">
                            <div class = "grid-x grid-padding-x">
                                <div class = "small-8 medium-4 large-4 cell">
                                    <label>Admin Password </label>
                                </div>

                                <div class = "small-4 medium-2 large-2 cell">
                                    <i class = "fa fa-info-circle has-tip middle" data-tooltip aria-haspopup="true" aria-hidden = "true" data-disable-hover="false" tabindex="1" title="Admin portal password." data-position="right" data-alignment="top"></i>
                                </div>
                                <div class = "small-12 medium-6 large-6 cell">
                                    <input type="password" name = "adminpass" id ="adminpass" placeholder="Admin Password..." autocomplete="off" >
                                </div>
                            </div>
                        </div>
                        <?php //Submit Button ?>

                        <div class="cell">
                          <input type="submit" name = "submit" class="submit" id="submit" value="Submit">
                        </div>

                    </form>
            </div>
            <div class = "large-3 cell"></div>
          </div>
        
        <script src="js/jquery.min.js"></script>
        <script  src = "js/vendor/foundation.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
<?php
}
else{
?>
<html>
    <head>
        <?php require_once 'admin_header_styles.php'; ?>
    </head>
    <body>
        <div class = "grid-x grid-padding-x">
            <div class = "large-3 cell"></div>
            <div class = "large-6 cell">
                <div class = "callout">
                    <h5>Already installed</h5>
                    <p>Serendipity has already been installed. To reinstall please clear old tables first.</p>
                    <a href = "login.php" class = "button secondary">Sign In</a>
                </div>
            </div>
            <div class = "large-3 cell"></div>
        </div>
        
    </body>
</html>
<?php
}
?>