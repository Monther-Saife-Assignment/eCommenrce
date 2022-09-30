<?php 

    session_start();  

    $pageTitle = 'Profile';

    include 'init.php';
    // As You See Here The Profile Page Depends On The Session
    
    // echo $sessionUser; We Will Count On This Session User
    if(isset($_SESSION['user'])) {

    $getUser = $con->prepare('SELECT * FROM users WHERE Username = ?');

    $getUser->execute(array($sessionUser));

    $info = $getUser->fetch();
    // echo $info['Username'];  // To Check
    // echo $info['Password'];  // To Check
?>

    <h1 class="h1"><?php  echo $_SESSION['user'] . ' Profile'; ?></h1>
    <!-- <h1 class="h1">My Profile</h1> -->

    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Information</div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li> 
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Login Name</span> : <?php echo $info['Username']; ?>
                        </li>
                        <li> 
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <span>Email</span> : <?php echo $info['Email']; ?>
                        </li>
                        <li> 
                            <i class="fa fa-user fa-fw"></i>
                            <span>Full Name</span> : <?php echo $info['FullName']; ?>
                        </li>
                        <li> 
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>RegDate</span> : <?php echo $info['Date']; ?>
                        </li>
                        <li> 
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Fav-Category</span> : 
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default">
                        Edit Information
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="my-items" class="my-ads block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Items</div>
                <div class="panel-body">
                    
                        <?php
                            $userid = $info['UserID'];
                            // $getItems = getAddItems('Member_ID', $userid, 1);
                            // AND Approve = 1
                            $getItems2 = getAllFromV2("*", "items", "WHERE Member_ID = $userid", "", "item_ID", 'DESC');
                            
                            if(!empty($getItems2)) {
                                echo '<div class="row">';
                                    foreach ($getItems2 as $items) {
                                        // echo $items['Name'] . '<br>';
                                        echo '<div class="col-sm-6 col-md-3">';
                                            echo '<div class="thumbnail item-box">';
                                                if($items['Approve'] == 0) { 
                                                    echo '<span class="approve-status">Waiting Approval</span>';}
                                                echo '<span class="price-tag">' . $items['Price']. '</span>';
                                                echo '<img src="info.jpg" class="img-responsive img-thumbnail" alt="" />'; 
                                                echo '<div class="caption">';
                                                    echo '<h3><a href="items.php?itemid=' . $items['item_ID']. '">' . $items['Name'] . '</a></h3>';
                                                    echo '<p>' . $items['Description'] . '</p>';
                                                    echo '<div class="date">' . $items['Add_Date'] . '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                echo '</div>';
                            } else {

                                echo 'There\'s no Comments To Show';

                            }
                        ?>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="my-comments block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Latest Comments</div>
                <div class="panel-body">
                    <?php

                        $myComments = getAllFromV2("Comment", "comments", "WHERE User_ID = {$info['UserID']}", "", "C_ID", "DESC");

                        // The Dynamic Function Dose The All Work
                        // $stmt = $con->prepare("SELECT Comment From comments WHERE User_ID = ?");
                        // // Execute The Statement
                        // $stmt->execute(array($info['UserID']));
                        // Assign To Variable 
                        // $comments = $stmt->fetchAll();

                        if(!empty($myComments)) {

                            foreach($myComments as $comment) {

                                echo "<p>" . $comment['Comment'] . "</p>";

                            }
                        } else {

                            echo 'There\'s No Comments To Show, Create New Ads <a href="newad.php">New Ads</a>';

                        }

                    ?>
                </div>
            </div>
        </div>
    </div>

<?php

    } else {

        header('Location: login.php');

        exit();

    }
    include $tpl . 'footer.php';     
?>