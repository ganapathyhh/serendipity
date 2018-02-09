<?php
    $current = "All Users";
    require_once 'header.php';
?>
<div class = "cell">
    <h3>Users</h3>
     <a href = "add_users.php" id = "add-button">
        <span class = "button"><i class = "fa fa-plus"></i> Add User</span>
    </a>
</div>
<div class = "small-12 cell">

    <form method="post" action="">
        <?php echo messages();?>
        <input type  = "hidden" name = "page_name" value = "<?php echo $current;?>">
        <div class = "grid-x grid-padding-x">
            <div class = "small-12 medium-3 large-3 cell">
                <div class = 'grid-x grid-padding-x'>
                    <div class = "small-6 medium-6 large-6 cell">
                        <select name = "user-table-action">
                            <option>-- Action --</option>
                            <option>Delete</option>
                        </select>
                    </div>
                    <div class = "small-6 medium-6 large-6 cell">
                        <input type = "submit" value="Apply" class = "button hollow" name = "action-button">
                    </div>
                </div>
            </div>
            <div class = "small-12 medium-3 large-3 cell">
                <div class = 'grid-x grid-padding-x'>
                    <div class = "small-6 medium-6 large-6 cell">
                        <select name= "user-table-role">
                            <option>-- Change role --</option>
                            <option>Administrator</option>
                            <option>Author</option>
                            <option>Editor</option>
                        </select>
                    </div>
                    <div class = "small-6 medium-6 large-6 cell">
                        <input type = "submit" value="Change" class = "button hollow" name='change-role-button'>
                    </div>
                </div>
            </div>

        </div>
        <table class = "stack">
                <tr>
                    <th><input type = "checkbox" class = "table-selector"></th>
                    <th><a href = "<?php echo $url;?>/all_users.php?orderby=user_login&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc') echo 'desc'; else echo 'asc';?>">
                Username  
                <?php 
                if(isset($_GET['orderby']) && $_GET['orderby'] == 'user_login' && isset($_GET['order']) && $_GET['order'] == 'asc')
                    echo '<i class = "fa fa-caret-up"></i>'; 
                else if(isset($_GET['orderby']) && $_GET['orderby'] == 'user_login') 
                    echo '<i class = "fa fa-caret-down"></i>';?>
                </a></th>
                    <th><a href = "<?php echo $url;?>/all_users.php?orderby=user_email&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc';else echo 'asc';?>">Email  <?php 
                    if(isset($_GET['orderby']) && $_GET['orderby'] == 'user_email' && isset($_GET['order']) && $_GET['order'] == 'asc')
                        echo '<i class = "fa fa-caret-up"></i>';
                    else if(isset($_GET['orderby']) && $_GET['orderby'] == 'user_email') 
                        echo '<i class = "fa fa-caret-down"></i>';?>
                    </a></th>
                    <th>Role</th>
                    <th>Posts</th>
                </tr>
            <?php 
            if(isset($_GET['orderby']) && $_GET['order']){
                $rs_result = GetDashboardData::getUsers($_GET['orderby'], $_GET['order']);
            }else{
                $rs_result = GetDashboardData::getUsers();
            }
            
                while($row = mysqli_fetch_assoc($rs_result)){
            ?>
                <tr>
                    
                    <td><input type = "checkbox" name = 'expand[]' value = "<?php echo $row['ID'];?>" class = "table-selector"></td>
                    <td data-label = "Username"><?php echo $row['user_login'];?> <?php /*<div><a id  "edit-user-details">Edit</a> <?php if($row['ID'] != $_SESSION['ID']) {?><a id = "delete-user">Delete</a><?php } </div>*/ ?><a class = "show-hidden-details"><i class = "fa fa-caret-down"></i></a></td>
                    <td data-label = "Email"><a href="mailto:<?php echo $row['user_email'];?>"><?php echo $row['user_email'];?></a></td>
                    <td data-label = "Role"><?php echo ucfirst($row['user_type']);?></td>
                    <td data-label = "Posts"><?php if($row['pages_total']) echo $row['pages_total']; else echo '0';?></td>
                </tr>
            <?php
                }
            ?>
        </table>
    </form>
</div>
<?php

            if(isset($_POST['action-button'])){
                GetDashboardData::deleteUser($_POST['expand'], $_POST['user-table-action']);
                header('Location: '.$_SERVER['REQUEST_URI']);     
            }

            if(isset($_POST['change-role-button'])){
                GetDashboardData::changeRole($_POST['expand'], $_POST['user-table-role']);
                header('Location: '.$_SERVER['REQUEST_URI']);     
            }
?>
<?php
require_once 'footer.php';
?>