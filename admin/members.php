<?php
    ob_start(); // Important -> To Fix Header Error 
    session_start();

    // $noNavbar = '';
    $pageTitle = 'Members';


    /**
     * ==================================================
     * == Menage Members Page
     * == You Can Add | Edit | Delete Members From Here
     * ==================================================
     */

    if (isset($_SESSION['Username'])){

        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page 
        if ($do == 'Manage') { // Manage Members Page 

            /*
                // Simple Example Over Check Items Function
                // Over The Manage Members Page
                $value = "jaksa";
                $check = checkItem("Username", "users", $value);
                if ($check == 1) {
                    echo 'Cool';
                }
            */

        $query = '';

        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

            $query = 'AND RegStatus = 0';
            
        }
        
            // Select All Users Except Admin 
        $stmt = $con->prepare("SELECT
                                    *
                                FROM 
                                    users 
                                WHERE 
                                    GroupID != 1 
                                    $query
                                ORDER BY 
                                    UserID DESC");

            // Execute The Statement
        $stmt->execute();
        
        // Assign To Variable
        $rows = $stmt->fetchAll();
        

        if (! empty($rows)) {
        ?>

            <h1 class="h1" class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table manage-members text-center table table-bordered">
                    <!-- manage-members 289 -->
                        <tr>
                            <td>#ID</td> 
                            <td>Avatar</td> 
                            <td>Username</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registered Date</td>
                            <td>Control</td>
                        </tr>
        <?php
                    foreach($rows as $row) {

                        echo "<tr>";
                            echo "<td>" . $row['UserID'] . "</td>";
                            echo "<td>"; 
                                if(empty($row['Avatar'])) {
                                    echo "No Image";
                                } else {
                                    echo "<img src='uploads/avatars/" . $row['Avatar'] . "'alt='' />";
                                }
                            echo "</td>";
                            echo "<td>" . $row['Username'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['FullName'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td>
                                <a href='members.php?do=Edit&userid=" . $row['UserID']  . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                <a href='members.php?do=Delete&userid=" . $row['UserID']  . "' class='confirm btn btn-danger'><i class='fa fa-close'></i> Delete</a>";

                                if ($row['RegStatus'] == 0) {
                                    echo "<a href='members.php?do=Activate&userid=" . $row['UserID']  . "' class='btn btn-info active'><i class='fa fa-check'></i> Activate</a>";

                                }

                            echo "</td>";
                        echo "</tr>";

                    } 
        ?>
                        </table>
                </div>
                <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
            </div>
            <?php } else {
                echo '<div class="container">';
                echo "<div class='nice-message'>There's No Members To Show</div>";
                echo '</div>';
            } 
            ?>

    <?php   } elseif ($do == 'Add') { // Add Members Page?>


            <!-- // echo "Welcome To Add Members Page"; -->
            <h1 class="h1" class="text-center">Add Member</h1>
                <div class="container">
                    <!-- The Default Value When Uploading Files enctype="application/x-www-form-urlencoded" -->
                    <form class="form-horizontal" action="members.php?do=Insert" method="POST" enctype="multipart/form-data"> 

                        <!-- Start Username Field--> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Username</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="text" name="username" class="form-control cont" autocomplete="off" required="required" placeholder="Username To Login Into The Shop"/>
                    </div>
                    <div>
                        <span>===============================================</span>
                    </div>
                        <!-- End Username Field--> 

                        <!-- Start Password Field--> 
                    <div class="form-group">
                        <label class=" col-sm-2 control-label" for="">Password</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="password" name="password" class="password form-control cont" autocomplete="new-password" required="required" placeholder="Password Must Be Hard & Complex"/>
                        <div class="eye"><i class="show-pass fa fa-eye fa-2x"></i></div>
                    </div>
                    <div>
                        <span>===============================================</span>
                    </div>
                        <!-- End Password Field--> 

                        <!-- Start Email Field--> 
                    <div class="form-group">
                        <label class=" col-sm-2 control-label" for="">Email</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="text" name="email" class="form-control cont" required="required" placeholder="Email Must Be Valid"/>
                    </div>
                    <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Email Field--> 

                        <!-- Start Full Name Field--> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Full Name</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="text" name="full" class="form-control cont" required="required" placeholder="Full Name Appear In Your Profile Page"/>
                    </div>
                    <div> 
                        <span>===============================================</span>
                    </div>
                        <!-- End Full Name Field--> 

                        <!-- Start Avatar Field--> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">User Avatar</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="file" name="avatar" class="form-control cont" placeholder="Your Personal Image"/>
                    </div>
                    <div> 
                        <span>===============================================</span>
                    </div>
                        <!-- End Avatar Field--> 

                        <!-- Start Username Field--> 
                    <div class="form-group">
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Member" class="btn btn-primary" />
                    </div>
                        <!-- End Username Field--> 
                    </form>
                </div>



    <?php   } elseif ($do == 'Insert') { //Insert Members Page 

                // Printing The Coming Data
                // echo $_POST['username'] . '<br>';
                // echo $_POST['password'] . '<br>';
                // echo $_POST['email'] . '<br>';
                // echo $_POST['full'] . '<br>';
    

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo '<h1 class="h1" class="text-center">Update Member</h1>';
                echo '<div class="container">';

                // Upload Variables
                $avatar   = $_FILES['avatar'];
                // print_r($avatar);

                // Some Unnecessary Data To Output
                // echo $_FILES['avatar']['name'] . '<br>';
                // echo $_FILES['avatar']['size'] . '<br>';
                // echo $_FILES['avatar']['tmp_name'] . '<br>';
                // echo $_FILES['avatar']['type'] . '<br>';

                $avatarName     = $_FILES['avatar']['name'];
                $avatarSize     = $_FILES['avatar']['size'];
                $avatarTmp      = $_FILES['avatar']['tmp_name'];
                $avatarType     = $_FILES['avatar']['type'];
                
                // List Of Allowed File Typed To Upload
                
                // Get Avatar Extension
                
                // Changing The String To Array Depending On A Specific Char
                // $avatarExtension = array("jpeg", "jpg", "png", "gif");
                // $string = 'Osman.Ahmed.Mohammed.Ali';
                // $avatarExtension = explode('.', $string);
                // print_r($avatarExtension);

                $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                // To Get The Image Extension We Use The End Function
                $avatarExtension = explode('.', $avatarName);
                $avatarExtension =  end($avatarExtension);
                $avatarExtension =  strtolower($avatarExtension);
                // echo $avatarExtension;

                // Get Variables From The Form
                $user   = $_POST['username'];
                $pass   = $_POST['password'];
                $email  = $_POST['email'];
                $name   = $_POST['full'];

                $hashPass   = sha1($_POST['password']);
                // echo $hashPass;

                // Validate The Form
                $formErrors = array();

                if (strlen($user) >= 1 && strlen($user) < 4 ) {
                    $formErrors[] = 'Username Cant Be Less Than <strong>4 Char</strong>';
                }

                if (strlen($user) > 20 ) {
                    $formErrors[] = 'Username Cant Be Bigger Than <strong>20 Char</strong>';
                }
    
                if (empty($user)) {
                    $formErrors[] = 'Username Cant Be <strong>Empty</strong>';
                }

                // if (empty($hashPass)) {
                //     $formErrors[] = 'Password Cant Be <strong>Empty</strong>';
                // }

                if (empty($name)) {
                    $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
                }               
                if (empty($email)) {
                    $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
                }
                if (!empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
                    $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
                }
                if (empty($avatarName)) {
                    $formErrors[] = 'Avatar Is <strong>Required</strong>';
                }
                if ($avatarSize > 4194304) {
                    $formErrors[] = 'Avatar Can\'t Be Larger Than <strong>4MB</strong>';
                }

                // Loop Into Error Array And Echo It
                foreach($formErrors as $error) {                      
                    // Echo Success Message
                    echo  '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check If There Is No Error Proceed The Update Operation
                if (empty($formErrors)) {
                    
                    // Check If User Exist In DataBase Or Not
                    $check = checkItem("Username", "users", $user);

                    if ($check == 1) {
                        // echo 'Sorry This User Is Exist';
                        $theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
                        redirectHome2($theMsg, "Back");
                    } else {
                        // Insert User Info To The DataBase 
                        // echo 'Good';
                        $avatar = rand(0,100000) . '_' . $avatarName;

                        move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
                        
                        $stmt = $con->prepare("INSERT INTO 
                                                users(Username, Password, Email, FullName, RegStatus, Date, Avatar)
                                                VALUES (:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar)");
                        
                        // $now = now();
                        $stmt->execute(array(

                        'zuser' => $user, 
                        'zpass' => $hashPass, 
                        'zmail' => $email, 
                        'zname' => $name,
                        'zavatar' => $avatar
                        ));    

                        // echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted</div>";
                        $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted</div>";

                        redirectHome2($theMsg, 'Back');
                        
                    }
                }   
            } else {
                echo '<div class="container">';
                    // echo 'Sorry Buddy You Cant Browse This Page Directly';

                    // $errorMsg = 'Sorry Buddy You Cant Browse This Page Directly';

                    $theMsg = '<div class="alert alert-danger error">Sorry Buddy You Cant Browse This Page Directly</div>';

                    // redirectHome($errorMsg, 6);
                    redirectHome2($theMsg, 'Back', 6);

                    // JS Page
                    // setTimeout('dashboard.php');
                echo '</div>';
            }
        
            echo'</div>';
    
            } elseif ($do == 'Edit') { //Edit Page 

                /*
                *=============================================
                *== Short If Code
                *== Check If Get Request userid Is Numeric & Get The Integer Value Of It
                *=============================================
                */
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
            
            // echo $userid  . '<br>';

                //  Long If Code
            // if (isset($_GET['userid']) && is_numeric($_GET['userid'])) {
            //     echo intval($_GET['userid']);
            // } else {
            //     echo 0;
            // }

        /**
            * =====================================================
            *== Select All Data Depend On This Id
            * =====================================================
            */

            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        // Execute Query
            $stmt->execute(array($userid));
        // Fetch The Data
            $row = $stmt->fetch();
            // echo $row['password'];
            // The Row Count 
            $count = $stmt->rowCount();
            // If There Is Such Id Show The Form
            if ($stmt->rowCount() > 0) { //echo 'Good This Is The Form';

                // <!-- Just For Fun -->

                echo '<h1 class="h1" class="text-center">Edit Member</h1>';
                echo '<div class="container">';
                ?>
                    <!-- Test -->
                    <!--
                            This Class Allows You To Put A Label 
                            On The Left, And An Input On The Right 
                        -->
                    <form class="form-horizontal" action="members.php?do=Update" method="POST">   
                        <input type="hidden" name="userid" value="<?php echo $userid ?>">  <!--$userid  &  $row['UserID']-->
                        <!-- Start Username Field--> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Username</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="text"
                                name="username" 
                                class="form-control cont" 
                                autocomplete="off" 
                                value="<?php echo $row['Username'] ?>" 
                                required="required"/>
                    </div>
                    <div>
                        <span>===============================================</span>
                    </div>
                        <!-- End Username Field--> 

                        <!-- Start Password Field--> 
                    <div class="form-group">
                        <label class=" col-sm-2 control-label" for="">Password</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="hidden" name="oldPassword" value="<?php echo $row['Password'] ?>" />
                        <input type="password" name="newPassword" class="form-control cont" autocomplete="new-password" placeholder="Leave Blank If You Don\'t Wanted To Be Changed"/>
                        <div class="eye"><i class="show-pass fa fa-eye fa-2x"></i></div>
                    </div>
                    <div>
                            <span>===============================================</span>
                    </div>
                        <!-- End Password Field--> 

                        <!-- Start Email Field--> 
                    <div class="form-group">
                        <label class=" col-sm-2 control-label" for="">Email</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="text" name="email" class="form-control cont" value="<?php echo $row['Email'] ?>" required="required"/>
                    </div>
                    <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Email Field--> 

                        <!-- Start Full Name Field--> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Full Name</label>
                    </div>
                    <div class="col-sm-offset-2 col-sm-7">
                        <input type="text" name="full" class="form-control cont" value="<?php echo $row['FullName']; ?>" required="required"/>
                    </div>
                    <div> 
                        <span>===============================================</span>
                    </div>
                        <!-- End Full Name Field--> 

                        <!-- Start Username Field--> 
                    <div class="form-group">
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save" class="btn btn-primary" />
                    </div>
                        <!-- End Username Field--> 
                    </form>
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

                $theMsg = '<div class="alert alert-danger">Sorry Buddy There\'s No Such ID</div>';                

                redirectHome2($theMsg, " ", 4);
                echo '</div>';
            }


                //==============================================================================
                // print_r($_SESSION); 
                // echo 'Welcome To Edit Page And Your Id Is ' . $_GET['userid'];
        } elseif ($do == 'Update') {    // Update Page
        
            echo "<h1 class='h1' class='text-center'>Update Member</h1>";
            echo '<div class="container">';

        
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variables From The Form

                $id     = $_POST['userid'];
                $user   = $_POST['username'];
                $email  = $_POST['email'];
                $name   = $_POST['full'];

                // Password Trick 
                //// The Short If
                $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

                
                ///////The Long If Code
                    // $pass = '';
                    // if (empty($_POST['newPassword'])) {
                    //     $pass = $_POST['oldPassword'];
                    // } else {
                    //     $pass = sha1($_POST['newPassword']);
                    // }
                

                // Validate The Form

                $formErrors = array();

                if (strlen($user) >= 1 && strlen($user) < 4 ) {

                    $formErrors[] = 'Username Cant Be Less Than <strong>4 Char</strong>';

                }
                if (strlen($user) > 20 ) {

                    $formErrors[] = 'Username Cant Be Bigger Than <strong>20 Char</strong>';

                }
                if (empty($user)) {

                    $formErrors[] = 'Username Cant Be <strong>Empty</strong>';

                }
                if (empty($name)) {

                    $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';

                }               
                if (empty($pass)) {

                    $formErrors[] = 'Password Cant Be <strong>Empty</strong>';

                }               
                if (empty($email)) {

                    $formErrors[] = 'Email Cant Be <strong>Empty</strong>';

                }

                // Loop Into Error Array And Echo It
                foreach($formErrors as $error) {

                    echo  '<div class="alert alert-danger">' . $error . '</div>';
                
                }

                // Check If There Is No Error Proceed The Update Operation
                if (empty($formErrors)) {

                    $stmt2 = $con->prepare("SELECT 
                                                *
                                            FROM 
                                                users
                                            WHERE
                                                Username = ?
                                            AND
                                                UserID != $id");

                    $stmt2->execute(array($user));

                    $count = $stmt2->rowCount();

                    // echo $count; If Its 1 Means This User Is Exist...

                    if ($count == 1) {

                        $theMsg = "<div class='alert alert-danger'>Sorry This User Is Exist</div>";

                        redirectHome2($theMsg, 'Back', 3);

                    } else {

                        // Update The DataBase With This Info

                        $stmt = $con->prepare("UPDATE 
                                                    users 
                                                SET 
                                                    Username = ?, 
                                                    Email = ?, 
                                                    FullName = ?, 
                                                    Password = ? 
                                                WHERE 
                                                    UserID = $id");

                        $stmt->execute(array($user, $email, $name, $pass));

                        // Echo the Success Message
                        // echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";

                        redirectHome2($theMsg, 'Back', 4);

                    }


                    
                }   

            } else {

                echo 'Sorry Buddy You Cant Browse This Page Directly';

                // $errorMsg2 = 'Sorry Buddy You Cant Browse This Page Directly';
                // redirectHome($errorMsg2);

            }
        ?> 
            </div>
        <?php
        } elseif ($do == 'Delete') {   // Delete Members Page 

                // echo 'Welcome To Delete Page';

                echo "<h1 class='h1' class='text-center'>Delete Member</h1>";
                echo "<div class='container'>";


                // Check If Get Request userid Is Numeric & Get The Integer Value Of It
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

                // Select All Data Depend On This Id
                // The Old Way Before The checkItem Function
                // $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

                $check = checkItem("userid", "users", $userid);
                // echo $check;  It Will Print Number 1

                 // Execute Query
                // $stmt->execute(array($userid)); You Will See It In The Func

                //$count = $stmt->rowCount(); You Will See It In The Func
                // If There Is Such Id Show The Form

                //if ($stmt->rowCount() > 0) { You Will See It In The Func
                if ($check > 0) {

                    $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
                        //DELETE FROM `users` WHERE `users`.`UserID` = 16"
                    $stmt->bindParam(":zuser", $userid);

                    $stmt->execute();

                    // echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";

                    redirectHome2($theMsg, 'Back', 4);

                } else {

                    // echo 'Sorry Buddy This ID is Not Exist';
                    $theMsg =  '<div class="alert alert-danger">Sorry Buddy This ID is Not Exist</div>';

                    redirectHome2($theMsg);


                }
                echo "</div>";  
        } elseif ($do = 'Activate') {  // Activate Members Page 

            // echo 'Activate';
            // echo 'Welcome To Activate Page';

            echo "<h1 class='h1' class='text-center'>Activate Member</h1>";
            echo "<div class='container'>";


            // Check If Get Request userid Is Numeric & Get The Integer Value Of It
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;


            $check = checkItem("userid", "users", $userid);

            if ($check > 0) {

                $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = $userid");

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Activated</div>";

                redirectHome2($theMsg, 'Back', 4);

            } else {

                $theMsg =  '<div class="alert alert-danger">Sorry Buddy This ID is Not Exist</div>';

                redirectHome2($theMsg);

            }
            echo "</div>"; 

        }

        include $tpl . 'footer.php';

    } else {

        header('Location: index.php');     // Redirect To index Page
        exit();

    }

    ob_end_flush();  // Important -> To Fix Header Error 
