<?php
function init($id){
    $_SESSION['PAGE_ID'] = $id;
}

function getSiteInfo(){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $res_set = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM se_meta WHERE ID = 1"));
    mysqli_close($conn);
    return $res_set;
}

function getSiteMeta(){
    $result = getSiteInfo();
    return $result['website_meta'];
}

function getSiteTitle(){
    return getSiteInfo()['website_title'];
}

function getPostTitle(){
    list($result, $c) = getPostInfo();
    if($c == 1)
        return ucfirst($result['page_title']);
    else return $result['website_title'];
}

function getPostSlug(){
    list($res, $c) = getPostInfo();
    return $res['page_url'];
}

function getPostContent(){
        list($result, $c) = getPostInfo();
        $content = '';
        $opened = false;
    if($c == 1){
        if(trim($result['page_template']) == 'Post' && $result['page_status'] == 'published' && strtotime($result['page_visible']) <= time()){
            $content .= ' added by '.$result['user_login'].' at '.date('d-M-y H:i', strtotime($result['page_added'])).getLikeDislike();
            $content .= '<div>'.$result['page_content'].'</div>';
            $opened = true;
        }else if(trim($result['page_template']) == 'Page' && $result['page_status'] == 'published' && strtotime($result['page_visible']) <= time()){
            $content .= 'by '.$result['user_login'].getLikeDislike();
            $content .= '<div>'.$result['page_content'].'</div>';
            $opened = true;
        }else if(trim($result['page_template']) == 'Event' && $result['page_status'] == 'published' && strtotime($result['page_visible']) <= time()){
            $res_remover = getEventExpiry($result['ID']);
            if(strtotime($res_remover['page_visible_remove']) <= time()){
                $content .= ' by '.$result['user_login'].' expires at '.date('d-M-y H:i', strtotime($res_remover['page_visible_remove'])).getLikeDislike();
                $content .= '<div>'.$result['page_content'].'</div>';
                $opened = true;
            }else{
                $content = "<h1>Oops, this has been deleted or moved permanently </h1>";
            }
        }
        else{
            $content = "<h1>Oops, this has been deleted or moved permanently </h1>";
        }
        /*if($opened){
            updateCount($_SESSION['PAGE_ID'], $result);
        }*/
        unset($_SESSION['PAGE_ID']);
    }else{
        $content .= $result['website_meta'];
        $content .= '<div>'.$result['website_description'].'</div>';
    }
        return $content;
}

function getHeader(){
    return include 'includes/header.php';
}

function getFooter(){
        return include 'includes/footer.php';

}

function getLikeDislike(){
    return '&nbsp;<div class = "page-pref"><a id = "like-button"><i class = "fa fa-thumbs-up fa-lg"></i></a>&nbsp;&nbsp;<a id = "dislike-button"><i class = "fa fa-thumbs-down fa-lg"></i></a></div>';
}

function updateCount($id, $result){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $counter = $result['page_hit'] + 1;
    mysqli_query($conn, "UPDATE se_pages SET page_hit = ".$counter." WHERE ID = ".$id);
    mysqli_close($conn);
}

function getEventExpiry($id){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM se_events WHERE event_id = ".$id));
    mysqli_close($conn);
    return $result;
}

function getPostInfo(){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $home = false;
    if(isset($_SESSION['PAGE_ID'])){
        $query = "SELECT * FROM se_pages pages LEFT JOIN (SELECT * FROM se_users) users ON users.ID = pages.author_ID WHERE pages.ID = ".$_SESSION['PAGE_ID'];
    }
    else{
        $query = "SELECT * FROM se_meta WHERE ID = 1";
        $home = true;
    }
    $res_postdata = mysqli_fetch_assoc(mysqli_query($conn, $query));
    mysqli_close($conn);
    if($home)
        return [$res_postdata, 0];
    else
        return [$res_postdata, 1];
}

function getWidgets(){
    return include 'includes/widget.php';
}

function getSideBar(){
    return include 'includes/sidebar.php';
}

function themeUrl($theme = ''){
    if($theme != '')
        return 'themes/'.$theme.'/';
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT theme_applied FROM se_meta WHERE ID = 1"));
    mysqli_close($conn);
    return 'themes/'.$row['theme_applied'].'/';
}

function themeGet($theme){
    return 'themes/'.$theme.'/';
}

?>