<?php 
if(isset($_GET['post_type']) && $_GET['post_type'] == 'page')
    $current = "All Pages";
else if(isset($_GET['post_type']) && $_GET['post_type'] == 'event')
    $current = "All Events";
else
    $current = "All Posts";

require_once 'header.php';
?>


<?php
if(isset($_GET['post_type']) && $_GET['post_type'] == 'page'){

?>
<div class = "cell">
    <h3><?php echo (explode(" ", $current)[1]); ?></h3>
    <a href = "add_new.php?post_type=page" class = "button primary"><i class = "fa fa-plus"> </i> Add <?php echo explode(' ', $current)[1]; ?></a>
</div>

<div class = "cell">
    <form method="post" action="">
        <div class = "grid-x grid-padding-x">
            <div class = "small-12 medium-3 large-3 cell">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-6 medium-6 large-6 cell">
                        <select name = "page-table-action">
                            <option>-- Action --</option>
                            <option>Delete</option>
                        </select>
                    </div>
                    <div class = "small-6 medium-6 large-6 cell">
                        <input type = "button" value="Apply" class = "button hollow">
                    </div>
                </div>
            </div>
            <div class = "small-12 medium-3 large-3 cell">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-6 medium-6 large-6 cell">
                        <select name= "page-table-published">
                            <option>-- Date --</option>
                            <option><?php
                                                              $result = mysqli_query($conn, "SELECT DISTINCT YEAR(page_added) as uniquedates  FROM se_pages");
                                                              $row = mysqli_fetch_assoc($result);
                                                              echo $row['uniquedates'];
                                                              ?></option>
                        </select>
                    </div>
                    <div class = "small-6 medium-6 large-6 cell">
                        <input type = "button" value="Filter" class = "button hollow">
                    </div>
                </div>
            </div>
        </div>
        <table class = "stack">
            
            <tr>
                <th><input type = "checkbox" name = "expand" class = "table-selector"></th>
                <th><a href = "<?php echo add_var_to_url('pages', 'user', $_SERVER['REQUEST_URI']);?>orderby=user_login&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc'; else echo 'asc';?>">Title</a></th>
                <th>Author</th>
                <th>Date</th>
            </tr>
            <?php $sql = "SELECT * FROM se_pages pages ";
                        
                        $sql .= "LEFT JOIN (SELECT ID, user_login FROM se_users) users ON users.ID = pages.author_ID";
                        if(isset($_GET['post_type']) && isset($_GET['order'])){
                            $sql .= " ORDER BY pages.".$_GET['orderby']." ".$_GET['order']." ";
                        }             
                        $sql .= " WHERE pages.page_template = 'Page'";
                        
            
                $rs_result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($rs_result)){
                 
            ?>
                <tr>
                    <td><input type = "checkbox" class = "table-selector" name  = "expand[]" value = "<?php echo $row['ID'];?>"></td>
                    <td data-label="Title"><?php echo $row['page_title'];?><a class = "show-hidden-details"><i class = "fa fa-caret-down"></i></a></td>
                    <td data-label="Author"><?php echo $row['user_login'];?></td>
                    <td data-label="Date" title = "<?php echo $row['page_added'];?>"><?php echo date('Y/m/d', strtotime($row['page_added']));?></td>
                  </tr>
            <?php
                }
            ?>
            </table>
    </form>
</div>
<?php
}else if(isset ($_GET['post_type']) && $_GET['post_type'] == 'event'){
    
?>
<div class = "cell">
    <h3><?php echo (explode(" ", $current)[1]); ?></h3>
    <a href = "add_new.php?post_type=event" class = "button primary"><i class = "fa fa-plus"> </i> Add <?php echo explode(' ', $current)[1]; ?></a>
</div>

<div class = "cell">    
    <form method="post" action="">
        <div class = "grid-x grid-padding-x">
            <div class = "small-12 medium-3 large-3 cell">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-6 medium-6 large-6 cell">
                        <select name = "post-table-action">
                            <option>Action</option>
                            <option>Delete</option>
                        </select>
                    </div>
                    <div class = "small-6 medium-6 large-6 cell">
                        <input type = "button" value="Apply" class = "button hollow">
                    </div>
                </div>
            </div>
            <div class = "small-12 medium-4 large-4 cell">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-4 medium-4 large-4 cell">
                
                        <select name= "user-table-dates">
                            <option>All dates</option>
                            <option>December 2017</option>
                        </select>
                    </div>
                    
                    <div class = "small-4 medium-4 large-4 cell">

                        <input type = "button" value="Filter" class = "button hollow">
                    </div>
                </div>
            </div>
        </div>
        <table>
            <tr>
                <th><input type = "checkbox" class = "table-selector"></th>
                <th><a href = "#0">Title</a></th>
                <th>Author</th>
                <th><a href = "#0">Date</a></th>
                <th><a href = "#0">Visible Date</a></th>
                <th><a href = "#0">Remove Date</a></th>
            </tr>
            <?php $sql = "SELECT * FROM se_pages pages ";
                        
                        $sql .= "LEFT JOIN (SELECT * FROM se_users) users ON users.ID = pages.author_ID";
                        $sql .= " LEFT JOIN (SELECT * FROM se_events) events ON pages.ID = events.event_id";
                        if(isset($_GET['post_type']) && isset($_GET['order'])){
                            $sql .= " ORDER BY pages.".$_GET['orderby']." ".$_GET['order']." ";
                        }             
                        $sql .= " WHERE pages.page_template = 'Event'";
                        
            
                $rs_result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($rs_result) >= 1){
                    while($row = mysqli_fetch_assoc($rs_result)){
                 
            ?>

                <tr>
                    <td><input type = "checkbox" name="expand[]" class = "table-selector"></td>
                    <td data-label="Title"><?php echo $row['page_title']; ?><a class = "show-hidden-details"><i class = "fa fa-caret-down"></i></a></td>
                    <td data-label="Author"><?php echo $row['user_login']; ?></td>
                     <td data-label="Date" title = "<?php echo date('Y-m-d H:i:s', strtotime($row['page_added']));?>"><?php echo date('Y/m/d', strtotime($row['page_added'])); ?></td>
                    <td data-label="Visible Date" title = "<?php echo date('Y-m-d H:i:s', strtotime($row['page_visible']));?>"><?php echo date('Y/m/d', strtotime($row['page_visible'])); ?></td>
                    <td data-label="Remove Date" title = "<?php echo date('Y-m-d H:i:s', strtotime($row['page_visible_remove']));?>"><?php echo date('Y/m/d', strtotime($row['page_visible_remove'])); ?></td>
                    
                  </tr>
            <?php
                }
                }
            ?>
        </table>
        
    </form>
</div>

<?php
}
else{
?>
    <div class = "cell">
    <h3><?php echo (explode(" ", $current)[1]); ?></h3>
    <a href = "add_new.php" class = "button primary"><i class = "fa fa-plus"> </i> Add <?php echo explode(' ', $current)[1]; ?></a>
</div>


<div class = "cell">
    <form method="post" action="">
        <div class = "grid-x grid-padding-x">
            <div class = "small-12 medium-3 large-3 cell">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-6 medium-6 large-6 cell">
                        <select name = "post-table-action">
                            <option>Action</option>
                            <option>Delete</option>
                        </select>
                    </div>
                    <div class = "small-6 medium-6 large-6 cell">
                        <input type = "button" value="Apply" class = "button hollow">
                    </div>
                </div>
            </div>
            <div class = "small-12 medium-4 large-4 cell">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-4 medium-4 large-4 cell">
                
                        <select name= "user-table-dates">
                            <option>All dates</option>
                            <option>December 2017</option>
                        </select>
                    </div>
                    <div class = "small-4 medium-4 large-4 cell">

                        <select name= "user-table-categorise">
                            <option>All categories</option>
                            <option>Uncategorized</option>
                        </select>
                    </div>
                    <div class = "small-4 medium-4 large-4 cell">

                        <input type = "button" value="Filter" class = "button hollow">
                    </div>
                </div>
            </div>
        </div>
        <table>
            <tr>
                <th><input type = "checkbox" class = "table-selector"></th>
                <th><a href = "#0">Title</a></th>
                <th>Author</th>
                <th>Categories</th>
                <th>Tags</th>
                <th><a href = "#0">Date</a></th>
            </tr>
            <?php $sql = "SELECT * FROM se_pages pages ";
                        
                        $sql .= "LEFT JOIN (SELECT * FROM se_users) users ON users.ID = pages.author_ID";
                        if(isset($_GET['post_type']) && isset($_GET['order'])){
                            $sql .= " ORDER BY pages.".$_GET['orderby']." ".$_GET['order']." ";
                        }             
                        $sql .= " WHERE pages.page_template = 'Post'";
                        
            
                $rs_result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($rs_result)){
                 
            ?>

                <tr>
                    <td><input type = "checkbox" name="expand[]" class = "table-selector"></td>
                    <td data-label="Title"><?php echo $row['page_title']; ?><a class = "show-hidden-details"><i class = "fa fa-caret-down"></i></a></td>
                    <td data-label="Author"><?php echo $row['user_login']; ?></td>
                     <td data-label="Categories">Uncategorized</td>
                     <td data-label="Tags">-</td>
                     <td data-label="Date" title = "<?php echo date('Y-m-d H:i:s', strtotime($row['page_added']));?>"><?php echo date('Y/m/d', strtotime($row['page_added'])); ?></td>
                    
                  </tr>
            <?php
                }
            ?>
        </table>
        
    </form>
</div>
<?php
}
?>
<?php
require_once 'footer.php';
?>