<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- <meta http-equiv="refresh" content="5;url=ht"> -->
        <title><?php getTitle(); ?></title>
        <!-- Fontawesome -->
        <link rel="stylesheet" href="<?php echo $css; ?>all.css">   <!-- Not Neede -->
        <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>fontawesome.min.css">   <!-- Not Neede -->

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">

        <!-- Main Backend Css File -->
        <!-- <link rel="stylesheet" href="layout/css/backend.css" /> -->
        <link rel="stylesheet" href="<?php echo $css; ?>front.css" />
    </head>
    <body>
        <div class="upper-bar">
            <div class="container">
                <!-- 
                    You Can Add This Feature...
                    target="_blank" 
                -->
                <?php
                    if (isset($_SESSION['user'])){ ?>
                        <img src="info.jpg" class="my-image img-responsive img-thumbnail img-circle" alt="" />
                        <div class="btn-group my-info">
                            <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <?php echo  $sessionUser ?>
                                <span class="caret"></span>
                            </span>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php">My Profile</a></li>   
                                <li><a href="newItem.php">Add New Item</a></li>
                                <li><a href="profile.php#my-items">My Items</a></li>
                                <li><a href="logout.php">Logout Page</a></li>
                            </ul>
                        </div>


                    <?php
                        // echo 'Welcome ' . $sessionUser . ' | ';
                        // echo '<a href="profile.php">My Profile</a>' . ' - '; 
                        // echo '<a href="logout.php">Logout</a>' . ' - '; // The Logout Page Depends On The Session
                        // echo '<a href="newad.php">New Ads</a>';
                        // echo checkUserStatus($_SESSION['user']);

                        // $userStatus = checkUserStatus($sessionUser);

                        // if ($userStatus == 1 ){
                        //     // echo '<br>' . 'Your Membership Need To Activate By Admin';  //////***User Is Not Active
                        // }

                    } else {
                ?>
                <a href="login.php">
                    <span class="pull-right">Login/Signup</span>
                </a>
                <?php } ?>
            </div>
        </div>
        <nav class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button class="alin" type="button" class="navbar toggle-collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><?php echo lang('HOME_PAGE'); ?></a>
                </div>
                <div class="collapse navbar-collapse navbar-right" id="app-nav">
                    <ul class="nav navbar-nav">
                        <?php
                            // $categories = getCats(); UnUsed Function...
                            $categories2 = getAllFromV2("*", "categories", "WHERE Parent = 0", "", "ID", "ASC");

                            foreach($categories2 as $cat) {
                                echo 
                                    '<li>
                                        <a href="categories.php?pageid=' . $cat['ID'] . '">
                                            ' . $cat['Name'] . '
                                        </a>
                                    </li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
