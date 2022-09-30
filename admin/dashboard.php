<?php
    ob_start(); // Important -> To Fix Header Error 

    /**
    ** ob_start("ob_gzhandler"); 
    ** Important -> To Fix Header Error  
    ** Used Inside The Huge WebSites
    */

    session_start();
    // $noNavbar = '';

    if (isset($_SESSION['Username'])){

        // If There Is A Session The Whole Content Of The Page Goes Here
        // header('Location: dashboard.php');     // Redirect To DashBoard Page
        // echo 'Wellcom ' . $_SESSION['Username'];

        $pageTitle = 'DashBoard';
        
        include 'init.php';
        /* Start DashBoard Page */

        // A Regular Query [We Will Make It As A Dynamic Function ]
        /*
            $stmt2 = $con->prepare("SELECT COUNT(UserID) FROM users");
            $stmt2->execute();
            echo $stmt2->fetchColumn();
        */

        $numUsers = 5; // Number Of The Latest Users
        $latestUsers = getLatest("*", "users", "UserID", $numUsers); // Latest User Array

        $numItems = 5; // Number Of The Latest Users
        $latestItems = getLatest("*", "items", "item_ID", $numItems); // Latest User Array

        $numComments = 4;   // Number Of Comments
        $latestComments = getLatest("*", "comments", "C_ID", $numComments); // Latest User Array



    ?>
        <div class="home-stats">
            <div class="container text-center">
                <h1 class="h1">Dashboard</h1>
                <div class="row">
                    <div class="col-md-3">
<!-- We Created This DIV To Avoid Modification Over The Grid-->
                        <div class="stat st-members">  
                        <i class="fa fa-users"></i>
                            <div class="info">
                                Total Members
                                <span>
                                    <a href="members.php"><?php echo countItems('UserID', 'users') ?></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                        <i class="fa fa-user-plus"></i>
                            <div class="info">
                                Pending Members
                                <span>
                                    <a href="members.php?do=Manage&page=Pending">
                                        <?php echo checkItem("RegStatus", "users", 0) ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-items">
                            <i class="fa fa-tag"></i>
                            <div class="info">
                                Total Items
                                <span>
                                    <a href="items.php?do=Manage">
                                        <?php echo countItems('item_ID', 'items') ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                            <div class="info">
                                Total Comments
                                <span>
                                    <a href="comments.php?do=Manage">
                                        <?php echo countItems('C_ID', 'comments') ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="latest">
            <div class="container ">
            <!-- Start -->
                <div class="col-sm-6">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <i class="fa fa-users"></i> 
                            Latest <?php echo $numUsers; ?> Registered Users
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                    if (! empty ($latestUsers)) {
                                        foreach($latestUsers as $user) {
                                            echo '<li>';
                                            echo $user['Username'];
                                            echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                                echo '<span class="btn btn-success pull-right">';
                                                    echo '<i class="fa fa-edit"></i> Edit';
                                                    if ($user['RegStatus'] == 0) {
                                                        echo "<a href='members.php?do=Activate&userid=" . $user['UserID']  . "' class='btn btn-info pull-right active'><i class='fa fa-check'></i> Activate</a>";
                                                    }
                                                echo '</span>';
                                            echo '</a>'; 
                                            echo '</li>';
                                        }
                                    } else {
                                        echo 'There\'s No Users To Show';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> 
                            Latest  <?php echo $numItems; ?> 
                            Items
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                                <?php
                                    if (! empty($latestItems)) {
                                        foreach($latestItems as $item) {
                                            echo '<li>';
                                            echo $item['Name'];
                                            echo '<a href="items.php?do=Edit&itmeid=' . $item['item_ID'] . '">';
                                                echo '<span class="btn btn-success pull-right">';
                                                    echo '<i class="fa fa-edit"></i> Edit';
                                                    if ($item['Approve'] == 0) {
                                                        echo "<a href='items.php?do=Approve&itmemid=" . $item['item_ID']  . "' class='btn btn-info pull-right active'><i class='fa fa-check'></i> Approve</a>";
                                                    }
                                                echo '</span>';
                                            echo '</a>'; 
                                            echo '</li>';
                                        }
                                    } else {
                                        echo 'There\'s No Users To Show';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End -->

            <!-- Start -->
            <div class="container ">
                <div class="col-sm-6">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <i class="fa fa-comments"></i> 
                            Latest <?php echo $numComments; ?> Comments
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                        <?php 
                            $stmt = $con->prepare("SELECT 
                                                    comments.*, 
                                                    users.Username AS Member_Name
                                                FROM 
                                                    comments
                                                INNER JOIN 
                                                    users
                                                ON 
                                                    users.UserID = comments.User_ID
                                                ORDER BY 
                                                    C_ID DESC
                                                LIMIT
                                                    $numComments");

                             // Execute The Statement
                            $stmt->execute();
                
                            // Assign To Variable
                            $latestComments = $stmt->fetchAll();

                            if (! empty($latestComments)) {

                                foreach ($latestComments as $comment) {
                                    echo "<div class='comment-box'>";
                                        // echo $comment['Member_Name'] . $comment['Comment']; Both Of Them Joined Together
                                        echo "<span class='member-n'>";
                                            echo "<a class='member-n-a' href='members.php?do=Edit&userid=" . $comment['User_ID']  . "'>" . $comment['Member_Name'] . "</a>";
                                        echo "</span>";
                                        echo "<p class='member-c'>" . $comment['Comment'] . "</p>";
                                    echo "</div>";
                                }

                            } else {
                                echo "There\'s No Comments To Show";
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End -->
        </div>

    <?php
            /* End DashBoard Page */

        include $tpl . 'footer.php';

    } else {

        // echo 'You Are Not Authorized To View This Page';
        header('Location: index.php');     // Redirect To index Page
        exit();

    }

    ob_end_flush(); // Important -> To Fix Header Error 