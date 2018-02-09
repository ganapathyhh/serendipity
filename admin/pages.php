<?php
$current = "All Pages";
require_once 'header.php';
?>
<h3>Pages</h3>
    <form method="post" action="">
        <select name = "user-table-action">
            <option>Action</option>
            <option>Delete</option>
        </select>
        <input type = "button" value="Apply" class = "reset">
        <select name= "user-table-role">
            <option>All dates</option>
            <option>December 2017</option>
        </select>
        <input type = "button" value="Filter" class = "reset">
        <div id="user-table">
            
            <div class="user-table-header-row user-table-row">
                <input type = "checkbox" name = "expand" class = "user-table-user-selector">
                <span class = "user-table-cell"><a href = "<?php echo add_var_to_url('pages', 'user', $_SERVER['REQUEST_URI']);?>?page=users&orderby=user_login&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc'; else echo 'asc';?>">Title</a></span>
            <span class="user-table-cell">Author</span>
             <span class="user-table-cell">Date</span>
            
          </div>
            <?php $sql = "SELECT * FROM se_pages pages ";
                        
                        $sql .= "LEFT JOIN (SELECT ID, user_login FROM se_users) users ON users.ID = pages.author_ID";
                        if(isset($_GET['post_type']) && isset($_GET['order'])){
                            $sql .= " ORDER BY pages.".$_GET['orderby']." ".$_GET['order']." ";
                        }             
                        
            
            $rs_result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($rs_result)){
                 
            ?>
                <div class="user-table-row">
                    <input type = "checkbox" class = "user-table-user-selector" name  = "expand[]" value = "<?php echo $row['ID'];?>">
                      <input type="checkbox"  class = "user-table-row-hider">
                        <span class="user-table-cell user-table-primary" data-label="Title"><?php echo $row['page_title'];?></span>
                    <span class="user-table-cell" data-label="Author"><?php echo $row['user_login'];?></span>
                    <span class="user-table-cell" data-label="Date"><?php echo date('Y/m/d', strtotime($row['page_added']));?></span>
                  </div>
            <?php
                }
            ?>
            </div>
    </form>
    
<?php
require_once 'footer.php';
?>