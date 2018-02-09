<?php
    $current = "Dashboard";
require_once 'header.php';
?>
<div class = "cell">
    <h3>Dashboard</h3>
</div>
<div class = "cell">
    <div class = "grid-x grid-margin-x" data-equalizer data-equalizer-on = "medium">
        <div class = "small-12 medium-6 large-3 cell" >
            <div class = "card" data-equalizer-watch>
                <div class="card-divider">
                    Create a new post
                  </div>
                  <div class="card-section clearfix">
                    <p>Posts are periodically created content which are added throughout the website's lifetime.</p>
                  </div>
                     <a href = "add_new.php" class = "button primary float-right"><i class = "fa fa-plus"></i> New Post</a>

            </div>
        </div>
        <div class = "small-12 medium-6 large-3 cell">
            <div class = "card" data-equalizer-watch>
                <div class="card-divider">
                    Create a new event
                  </div>
                  <div class="card-section clearfix">
                    <p>Events are temporary posts/pages that are created for a special occassion or seasonal content, which needs to disappear after a time.</p>
                  </div>
                <a href = "add_new.php?post_type=event" class = "button primary float-right"><i class = "fa fa-plus"></i> New Event</a>

            </div>
        </div>
        <div class = "small-12 medium-6 large-3 cell">
            <div class = "card" data-equalizer-watch>
                <div class="card-divider">
                    Create a new page
                  </div>
                  <div class="card-section clearfix">
                    <p>Pages are permanent uncategorized content with permalinks for often visited content.</p>
                  </div>
                     <a href = "add_new.php?post_type=page" class = "button primary float-right"><i class = "fa fa-plus"></i> New Page</a>

            </div>
        </div>
        <div class = "small-12 medium-6 large-3 cell">
            <div class = "card" data-equalizer-watch>
                <div class="card-divider">
                    Create a new widget
                  </div>
                  
                  <div class="card-section clearfix">
                    <p>Widgets are additional pieces of code which can be added to enhance the webpages.</p>
                  </div>
                     <a href = "widgets.php" class = "button primary float-right"><i class = "fa fa-plus"></i> New Widget</a>

            </div>
        </div>
    </div>
    <div class = "grid-x grid-margin-x count-stats" data-equalizer data-equalizer-on = "medium">
        <?php 
            $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
            $post_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS post_total FROM se_pages WHERE page_template = 'Post'"));
            $post_published = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS post_total FROM se_pages WHERE page_template = 'Post' AND page_status = 'published' AND page_visible <= NOW()"));
            $post_scheduled = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS post_total FROM se_pages WHERE page_template = 'Post' AND page_status = 'published' AND page_visible >= NOW()"));
            $page_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS page_total FROM se_pages WHERE page_template = 'Page'"));
            $page_published = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS page_total FROM se_pages WHERE page_template = 'Page' AND page_status = 'published' AND page_visible <= NOW()"));
            $page_scheduled = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS page_total, page_visible FROM se_pages WHERE page_template = 'Page' AND page_status = 'published' AND page_visible >= NOW()"));

            $event_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS event_total FROM se_pages WHERE page_template = 'Event'"));
            $event_published = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS event_total FROM se_pages WHERE page_template = 'Event' AND page_status = 'published' AND page_visible <= NOW()"));
            $event_scheduled = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS event_total FROM se_pages WHERE page_template = 'Event' AND page_status = 'published' AND page_visible >= NOW()"));

            $admin_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS admin_total FROM se_users WHERE user_type = 'administrator'"));
            $author_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS author_total FROM se_users WHERE user_type = 'author'"));
            $editor_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ID) AS editor_total FROM se_users WHERE user_type = 'editor'"));
        ?>
        <div class = "small-12 medium-6 large-4 cell " >
            <div class = "card" data-equalizer-watch>
                  <div class="card-section clearfix">
                    <p class = "stat"><?php echo $post_count['post_total']; ?></p>
                      <p>Post(s)</p>
                      
                      <p class = "float-left">
                        <span>Published: <?php echo $post_published['post_total']; ?></span>
                      </p>
                      <p class = "float-right">
                        <span>Scheduled: <?php echo $post_scheduled['post_total']; ?></span>
                      </p>
                  </div>
            </div>
        </div>
        <div class = "small-12 medium-6 large-4 cell" >
            <div class = "card" data-equalizer-watch>
                  <div class="card-section clearfix">
                    <p class = "stat"><?php echo $page_count['page_total']; ?></p>
                      <p>Page(s)</p>
                      
                      <p class = "float-left">
                        <span>Published: <?php echo $page_published['page_total']; ?></span>
                      </p>
                      <p class = "float-right">
                        <span>Scheduled: <?php echo $page_scheduled['page_total']; ?></span>
                      </p>
                  </div>
            </div>
        </div>
        <div class = "small-12 medium-6 large-4 cell" >
            <div class = "card" data-equalizer-watch>
                  <div class="card-section clearfix">
                    <p class = "stat"><?php echo $event_count['event_total']; ?></p>
                      <p>Event(s)</p>
                      <p class = "float-left">
                        <span>Published: <?php echo $event_published['event_total']; ?></span>
                      </p>
                      <p class = "float-right">
                        <span>Scheduled: <?php echo $event_scheduled['event_total']; ?></span>
                      </p>
                  </div>
            </div>
        </div>
        <div class = "small-12 medium-6 large-4 cell">
            <div class = "card" data-equalizer-watch>
                  <div class="card-section clearfix">
                    <p class = "stat"><?php echo $admin_count['admin_total']; ?></p>
                      <p>Administrator(s)</p>
                  </div>
            </div>
        </div>
        <div class = "small-12 medium-6 large-4 cell">
            <div class = "card" data-equalizer-watch>
                  <div class="card-section clearfix">
                    <p class = "stat"><?php echo $author_count['author_total']; ?></p>
                      <p>Author(s)</p>
                  </div>
            </div>
        </div>
        <div class = "small-12 medium-6 large-4 cell">
            <div class = "card" data-equalizer-watch>
                  
                  <div class="card-section clearfix">
                    <p class = "stat"><?php echo $editor_count['editor_total']; ?></p>
                      <p>Editor(s)</p>
                  </div>
            </div>
        </div>
    </div>
   <?php /* <div class="chart-container" style="position: relative; height:40vh; width:80vw">
        <canvas id="chart"></canvas>
    </div>*/ ?>
</div>

<?php
require_once  "footer.php";
?>