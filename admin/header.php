<?php 
session_start();

/**
*If session started and timestamp is set
*
*Checks for timestamp and this time's difference to be greater than 15mins to end session due to inactivity
*
*Otherwise the timestamp will be reset to the current time
*/

/*if(time() - $_SESSION['TIMESTAMP'] > 900) { //subtract new timestamp from the old one
    echo"<script>alert('You have to login to continue!');</script>";
    unset($_SESSION['AUTHORIZED'], $_SESSION['TIMESTAMP']);
    $_SESSION['ERROR'] = "You have been logged out due to inactivity for more than 15mins";
    header("Location: login.php"); //redirect to index.php
    exit;
}else {
    $_SESSION['TIMESTAMP'] = time(); //set new timestamp
}*/

/**
*Requires checkup.php present at root of this product
*/

ob_start();
require_once '../checkup.php';

/**
*A boolean function to check whether the serendipity is installed
*
*This checks for file config.ini
*
*When not installed it redirects to install.php
*/

if(!is_installed()){  //Check whether installed
    unset($_SESSION['AUTHORIZED']);
    header('location: install.php');
    exit();
}

/**
*After installation when redirected here, it checks for tables
*
*If tables required are not present at the database, installation file will be called
*/

if(!check_connection())
    header('location: install.php');
require_once 'includes/function.php'; 
require_once 'includes/get_db_data.php';

/**
*Checks whether user is logged in
*
*Otherwise the page will be redirected to login page
*
*If get[logout] is set then the user will be logged out
*/

if(!logged_in())  //check whether logged in
    header('location: login.php');
else if(isset($_GET['logout']))
    logout();
?>
<!DOCTYPE html>
<html>
<head>
    <?php 
        $url  = isset($_SERVER['HTTPS'])?'https://':'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
    ?>
    
    <?php
    /**
    *Title changed based on the $current variable obtained from other pages
    */
    ?>
    
    <title><?php if(isset($current))echo $current; else echo 'Home'; echo ' < '.WEBSITE_TITLE.' | Serendipity';?></title>
    
    <?php
    /**
    *Linking all the style sheets required for the site
    *
    *The stylesheets are used from foundation
    *
    *Style.css is the main site style
    */
    ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href = "css/foundation.min.css">
    <link rel = "stylesheet" href = "../../font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href = "css/style.css"/>
</head>
<body>
    
    <?php
    /**
    *This is the topbar section
    *
    *This has te logo at the left
    *
    *After logo a link to site is provied
    *
    *At the right, messages listed provides the activities of various users toward security of this portal
    *
    *After that profile options are provided to edit, change details and logout from the account
    */
    ?>
    <div id = "first"></div>
    <div>
        <div class="title-bar site-header">
            <div class="title-bar-left">
                <a href = "<?php echo $url; ?>"><img src = "img/logo.png" height="25px" width="25px"></a>
                <div class = "menu-icon show-for-small-only" id = "menu-open"></div>
                <span class = "menu-text"> <a href = "<?php echo WEBSITE_URL;?>" ><i class = "fa fa-home"></i>Visit site</a> </span>
            </div>
            <div class="top-bar-right title-bar-left">
                <ul class="dropdown menu menu-right" data-dropdown-menu>
      
                   <?php /* <li><a href="#"><i class = "fa fa-bell"></i></a>
                        <ul class="menu vertical dropper">
                            <li class = 'clearfix'>
                                <a href = "#">
                                    <div class = "grid-x grid-margin-x">
                                        <div class = "small-9 large-8 cell">
                                            <span><small>John account activated</small></span>
                                        </div>
                                        <div class = "small-3 large-4 cell">
                                            <span><small>Today</small></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class = 'clearfix'>
                                <a href = "#">
                                    <div class = "grid-x grid-margin-x">
                                        <div class = "small-9 large-8 cell">
                                            <span><small>Abraham changed password</small></span>
                                        </div>
                                        <div class = "small-3 large-4 cell">
                                            <span><small>Today</small></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                    </ul>
                </li> */ ?>
                    
                    <?php
                    /**
                    *Profile settings and profile section
                    *
                    *Dropdown with account settings, logout, about sections
                    */
                    ?>
                    
                <li><a href="#"><img src = "<?php if(!isset($_SESSION['ID']) && !empty($_SESSION['ID'])) echo 'profile/'.$_SESSION['ID'].'.png'; else echo 'profile/default.png';?>"></a>
                    <ul class="menu vertical dropper">
                      <li><a href="#">Account</a></li>
                      <li><a href="<?php echo $_SERVER['PHP_SELF'];?>?logout=true">Logout</a></li>
                      <li><a href="#">About</a></li>
                    </ul>
                </li>
            </ul>
        </div>
     </div>
</div>
    
    <?php
    /**
    *Sidebar and its components
    *
    *Absolute url is provided to all the pages
    *
    *is-active is provided to current page category
    *
    *current is provided to make submenu active
    *
    *Based on $current variable the toggles for is-active is performed
    */
    ?>
    
    <div id = "side-bar">
    </div>
    <div class = "side-bar" >
        <ul class=" vertical menu parent"  id = "side-bar-menu">
            <li <?php if($current == 'Dashboard') echo 'class = "is-active"'; ?>>
                <a href="<?php echo $url; ?>/dashboard.php"><i class = "fa fa-dashboard"></i><span>Dashboard</span></a>
            </li>
            
            <?php
            /**
            *This is for the post
            *
            *This has view all posts
            *
            *Then has the adding new post option
            *
            *Has the category viewing and adding option
            *
            *Has tags viewing and adding option
            */
            ?>
            
            <li class = "has-vertical <?php if($current == 'All Posts' || $current  == 'Add Post' || $current == 'Category' || $current == 'Tag') echo 'is-active'; ?>">
                <a href="<?php echo $url; ?>/all_posts.php"><i class = "fa fa-tags"></i><span>Post</span></a>
                <ul class="vertical menu nested services-list-container addtriangle">
                    <span class = "services-list-container-header <?php if($current == 'All Posts' || $current  == 'Add Post' || $current == 'Category' || $current == 'Tag') echo 'label primary'; ?>">Post</span>
                    <li <?php if($current == 'All Posts') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/all_posts.php" ><span>All Posts</span></a>
                    </li>
                    <li <?php if($current == 'Add Post') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/add_new.php"><span>Add New</span></a>
                    </li>
                    <li <?php if($current == 'Category') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/taxonomy.php?tag_type=category"><span>Categories</span></a>
                    </li>
                    <li <?php if($current == 'Tag') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/taxonomy.php"><span>Tags</span></a>
                    </li>
                </ul>
            </li>
            
            <?php
            /**
            *This is for the pages section
            *
            *This helps in viewing all the pages
            *
            *Adding new page is available next to all pages section
            */
            ?>

            <li class = "has-vertical <?php if($current == 'All Pages' || $current  == 'Add Page') echo 'is-active'; ?>">
                <a href="<?php echo $url; ?>/all_posts.php?post_type=page"><i class = "fa fa-file-text"></i><span>Pages</span></a>
                <ul class="vertical menu nested services-list-container addtriangle">
                    <span class = "services-list-container-header <?php if($current == 'All Pages' || $current  == 'Add Page') echo 'label primary'; ?>">Pages</span>
                    <li <?php if($current == 'All Pages') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/all_posts.php?post_type=page"><span>All Pages</span></a>
                    </li>
                    <li <?php if($current == 'Add Page') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/add_new.php?post_type=page"><span>Add New</span></a>
                    </li>
                </ul>
            </li>
            
            <?php 
            /**
            *Events for certain period of time
            *
            *Display events to users for certain period of time
            */ 
            ?>
            
            <li class = "has-vertical <?php if($current == 'All Events' || $current  == 'Add Event') echo 'is-active'; ?>">
                <a href="<?php echo $url; ?>/all_posts.php?post_type=event"><i class = "fa fa-calendar"></i><span>Events</span></a>
                <ul class="vertical menu nested services-list-container addtriangle">
                    <span class = "services-list-container-header <?php if($current == 'All Events' || $current  == 'Add Event') echo 'label primary'; ?>">Events</span>
                    <li <?php if($current == 'All Events') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/all_posts.php?post_type=event"><span>All Events</span></a>
                    </li>
                    <li <?php if($current == 'Add Event') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/add_new.php?post_type=event"><span>Add New</span></a>
                    </li>
                </ul>
            </li>
            
            <?php
            /**
            *User section
            *
            *This helps in viewing all the users from the database
            *
            *New users can be added into the database
            */
            ?>
            
            <li class = "has-vertical <?php if($current == 'All Users' || $current  == 'Add User') echo 'is-active'; ?>">
                <a href="<?php echo $url; ?>/all_users.php"><i class = "fa fa-user"></i><span>Users</span></a>
                <ul class="vertical menu nested services-list-container addtriangle">
                    <span class = "services-list-container-header <?php if($current == 'All Users' || $current  == 'Add User') echo 'label primary'; ?>">Users</span>
                    <li <?php if($current == 'All Users') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/all_users.php"><span>All Users</span></a>
                    </li>
                    <li <?php if($current == 'Add User') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/add_user.php"><span>Add New</span></a>
                    </li>
                </ul>
            </li>
            
            <?php
            /**
            *Appearance section
            *
            *Customise the themes of the site
            *
            *Add or remove widgets from the site
            *
            *Change theme for the site
            */
            ?>
            
            <li class = "has-vertical <?php if($current == 'Themes' || $current  == 'Customize' || $current  == 'Widgets') echo 'is-active'; ?>">
                <a href="<?php echo $url; ?>/themes.php"><i class = "fa fa-paint-brush"></i><span>Appearance</span></a>
                <ul class="vertical menu nested services-list-container addtriangle">
                    <span class = "services-list-container-header <?php if($current == 'Themes' || $current  == 'Customize' || $current  == 'Widgets') echo 'label primary';?>">Appearance</span>
                    <li <?php if($current == 'Themes') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/themes.php"><span>Themes</span></a>
                    </li>
                    <li <?php if($current == 'Customize') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/customize.php"><span>Customize</span></a>
                    </li>
                    <li <?php if($current == 'Widgets') echo 'class = "current"';?>>
                        <a href="<?php echo $url; ?>/widgets.php"><span>Widgets</span></a>
                    </li>
                </ul>
            </li>
            
            <?php
            /**
            *Setting and Tools section
            *
            *Settings section helps in changing various settings of the site
            *
            *Tools helps in import and export of data from the database and into the database
            */
            ?>
            
            <li <?php if($current == 'Settings') echo 'class = "is-active"'; ?>>
                <a href="<?php echo $url; ?>/settings.php"><i class = "fa fa-cog"></i><span>Settings</span></a>
            </li>
            <li class = "has-vertical <?php if($current == 'Import' || $current == "Export") echo 'is-active'; ?>">
                <a href="<?php echo $url;?>/import.php"><i class = "fa fa-wrench"></i><span>Tools</span></a>
                <ul class="vertical menu nested services-list-container addtriangle">
                    <span class = "services-list-container-header <?php if($current == 'Import' || $current == "Export") echo 'label primary';?>">Appearance</span>
                    <li <?php if($current == 'Import') echo 'class = "current"';?>>
                        <a href = "<?php echo $url;?>/import.php">Import</a>
                    </li>
                    <li <?php if($current == 'Export') echo 'class = "current"';?>>
                        <a href = "<?php echo $url;?>/export.php">Export</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <?php
    /**
    *From this the content section starts
    *
    *Based on various page contents the pages and posts are added
    *
    *Users are added and edited
    *
    *Content management system functions are defined and provided with styles at this section
    */
    ?>
    
    <div class = "grid-x grid-padding-x" id = "content">