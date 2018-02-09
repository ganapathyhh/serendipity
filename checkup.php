<?php

$timezone_offset_minutes = 330;  // $_GET['timezone_offset_minutes']

// Convert minutes to seconds
$timezone_name = timezone_name_from_abbr("", $timezone_offset_minutes*60, false);

date_default_timezone_set($timezone_name);

//Check for file existance
define('INCLUDED', 1);

/**
*Checks whether Serendipity is installed using file existance.
*
*If file exists, then All the variables related to database are defined.
*/

if(is_installed()){
    $config = parse_ini_file(file_exists('config.ini')?'config.ini':'/tmp/config.ini');
    define('DBHOST', $config['DBHOST']);
    define('DBUSER', $config['DBUSER']);
    define('DBPASS', $config['DBPASS']);
    define('DBNAME', $config['DBNAME']);    
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $meta_results = mysqli_query($conn, "SELECT * FROM se_meta WHERE ID = 1");
    while($row = mysqli_fetch_assoc($meta_results)){
        define('WEBSITE_URL', $row['website_url']);
        define('WEBSITE_TITLE', $row['website_title']);
        define('ADMIN_EMAIL', $row['primary_admin']);
        if(!empty($row['website_meta']))
            define('SITE_META', $row['website_meta']);
        if(!empty($row['website_description']))
            define('SITE_DESCR', $row['website_description']);
        if($row['page_hit'] != 0)
            define('SITE_HIT', $row['page_hit']);
        if($row['page_like'] != 0)
            define('SITE_LIKE', $row['page_like']);
        if($row['page_dislike'] != 0)
            define('SITE_DISLIKE', $row['page_dislike']);
    }
    mysqli_close($conn);
    
}


/**
*Defining absolute path to this file
*
*Defines the constant if already not defined.
*/

if(!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__));

//To get current working directory for any php file
function cur_dir(){
    return dirname($_SERVER['PHP_SELF']);
}

/**
*Check installtion using file existance
*
*Returns true or false based on file existance
*/

//To check installation
function is_installed(){
    if(file_exists('config.ini') || file_exists('/tmp/config.ini')){
        return true;
    }
    return false;
}

/**
*Checks databse connection
*
*Returns true if successfully connected
*
*Returns false if connection fail
*/

function check_connection(){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    mysqli_close($conn);
    if($conn)
        return true;
    return false;
}
?>