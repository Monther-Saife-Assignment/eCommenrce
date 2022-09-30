<?php 

    ob_start();

    session_start();  

    $pageTitle = 'Show Items';

    include 'init.php';

    /*
    *== Short If Code
    *== Check If Get Request itemid Is Numeric & Get The Integer Value Of It
    */
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

        //Select All Data Depend On This Id
    $stmt = $con->prepare("SELECT 
                                items.*, 
                                categories.Name As Category_Name,
                                users.Username AS Member_Name
                            FROM 
                                items
                            INNER JOIN 
                                categories
                            ON
                            categories.ID = items.Cat_ID
                            INNER JOIN 
                                users
                            ON
                            users.UserID = items.Member_ID
                            WHERE
                                item_ID = ?
                            AND
                                Approve = 1");

    // Execute Query
    $stmt->execute(array($itemid));

    
    // The item Count 
    $count = $stmt->rowCount();
    
    if ($count > 0) { //echo 'Good This Is The Form';

    // Fetch The Data
    $item = $stmt->fetch();
?>
    <h1 class="h1"><?php  echo $item['Name']; ?></h1>
    
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="info.jpg" class="img-responsive img-thumbnail center-block"  alt="" />
            </div>
            <div class="col-md-9">
                <div class="item-info">
                    <h2><?php echo $item['Name'] ?></h2>
                    <p><?php echo $item['Description'] ?></p>
                    <!-- Using "list-unstyled" Bootstrap Will Remove All The ul Style -->
                    <ul class="list-unstyled"> 
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Added Date</span> :<?php echo $item['Add_Date'] ?>
                        </li>
                        <li>
                            <i class="fa fa-dollar fa-fw"></i>
                            <span>Price</span> : <?php echo $item['Price'] ?>
                        </li>
                        <li>
                            <i class="fa fa-building fa-fw"></i>
                            <span>Made In</span> : <?php echo $item['Country_Made'] ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?> "><?php echo $item['Category_Name'] ?></a>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By</span> : <a href="#'"><?php echo $item['Member_Name'] ?></a> 
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Tags </span> : 
                            <?php
                                $allTags = explode(",", $item['Tags']);
                                foreach ($allTags as $tag) {
                                    $smallTag = str_replace(' ', '', $tag); ?>
                                    <?php if(! empty($tag)){ ?>
                                        <a href="tags.php?name=<?php echo strtolower($smallTag) ?> "> <?php echo $tag; ?> </a> 
                                    <?php } ?>
                                    <!-- // $lowerTag = strtolower($tag); // It Will Be Small Every Where  --> 
                                    <!-- // echo "<a href='tags.php?name='{$lowerTag}'>"  . $tag . '</a> | '; -->
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="custom-hr">
        <!-- Start Section Comment  -->
        <?php if (isset($_SESSION['user'])){ ?>
        <div class="row">
            <div class="col-md-offset-3">
                <div class="add-comment">
                    <h3>Add Your Comment</h3>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['item_ID'] ?>" method="POST">
                        <!-- We Have A Class Called Form Control From Bootstrap -->
                        <textarea name="comment" id="" cols="50" rows="5" required></textarea> <!-- We Have Style From Css Too -->
                        <input type="submit" class="btn btn-primary" value="Add Comment">
                    </form>
                    <?php
                    
                        if($_SERVER['REQUEST_METHOD'] == 'POST'){

                            // $comment = $_POST['comment'];
                            // echo $comment;

                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $itemid = $item['Member_ID'];
                            $userid = $_SESSION['uid'];

                            if(! empty($comment)) {
                                    // Select All Users Except Admin 
                                $stmt = $con->prepare("INSERT INTO
                                                            comments(Comment, Status, Comment_Date, Item_ID, User_ID)
                                                        VALUES(:zcomment, 0, now(), :zitemid, :zuserid)");

                                // Execute The Statement
                                $stmt->execute(array(

                                    'zcomment'    => $comment,
                                    'zitemid'     => $itemid,
                                    'zuserid'     => $userid

                                ));

                                if ($stmt) {

                                    echo '<div class="alert alert-success">Done "Comment Added"</div>';
 
                                }
                            } else {

                                echo '<div class="alert alert-danger">Sorry "Comment Is Empty"</div>';

                            }

                        }
                    
                    ?>
                </div>
            </div>
        </div>
        <?php
            } else {
                echo '<div class="alert alert-danger">Please <a href="login.php">Login</a> Or <a href="login.php">Register</a> To Add Comment</div>';
            }
        ?>
        <!-- End Section Comment  -->
        <hr class="custom-hr">
        <?php
        
            // Select All Users Except Admin 
            $stmt = $con->prepare("SELECT 
                                        comments.*, 
                                        users.Username AS Member_Name
                                    FROM 
                                        comments
                                    INNER JOIN 
                                        users
                                    ON 
                                        users.UserID = comments.User_ID
                                    WHERE 
                                        item_ID = ?
                                    AND
                                        Status = 1
                                    ORDER BY 
                                        C_ID DESC");

            // Execute The Statement
            $stmt->execute(array($itemid));

            // Assign To Variable
            $comments = $stmt->fetchAll();
        ?> 
            <?php foreach($comments as $comment ) { ?>
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-sm-2 text-center"> 
                                <img src="info.jpg" class="img-responsive img-thumbnail img-circle center-block" alt="" />
                            <?php echo $comment['Member_Name'] ?> 
                            </div>
                            <div class="col-sm-10"> 
                                <p class="lead"><?php echo $comment['Comment'] ?></p> 
                            </div>
                        </div>
                    </div>
                    <hr class="custom-hr">
            <?php } ?>
    </div>
    
<?php
    }else { 
        /**
        * =====================================================
        *== If There's No Such ID Show Error Message
        * =====================================================
        */
        echo '<div class="container">';
        
        // echo 'Sorry Buddy There\'s No Such ID';

        echo '<div class="alert alert-danger">Sorry Buddy There\'s No Such ID Or The Item You Choose Is Not Approved (Waiting Approval)</div>';                

        echo '</div>';
    }
    include $tpl . 'footer.php';  
    ob_end_flush();
?>