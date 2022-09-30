<?php
    ob_start(); // Important -> To Fix Header Error 
    session_start();

    // $noNavbar = '';
    $pageTitle = 'Comments';


    /**
     * ==================================================
     * == Menage Comments Page
     * == You Can Edit | Delete | Approve Comments From Here
     * ==================================================
     */

    if (isset($_SESSION['Username'])){

        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page 
        if ($do == 'Manage') { // Manage Comments Page 

        
            // Select All Users Except Admin 
        $stmt = $con->prepare("SELECT 
                                    comments.*, 
                                    items.Name AS Item_Name, 
                                    users.Username AS Member_Name
                                FROM 
                                    comments
                                INNER JOIN 
                                    items
                                ON
                                    items.item_ID = comments.Item_ID
                                INNER JOIN 
                                    users
                                ON 
                                    users.UserID = comments.User_ID
                                ORDER BY 
                                    C_ID DESC");

            // Execute The Statement
        $stmt->execute();
        
        // Assign To Variable
        $comments = $stmt->fetchAll();

        if (! empty($comments)) {
?>
            <h1 class="h1" class="text-center">Manage Comments</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                    
                        <tr>
                            <td>ID</td> 
                            <td>Comment</td>
                            <td>Item Name</td>
                            <td>Member Name</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>
                    <?php
                    foreach($comments as $com) {

                        echo "<tr>";
                            echo "<td>" . $com['C_ID'] . "</td>";
                            echo "<td>" . $com['Comment'] . "</td>";
                            echo "<td>" . $com['Item_Name'] . "</td>";
                            echo "<td>" . $com['Member_Name'] . "</td>";
                            echo "<td>" . $com['Comment_Date'] . "</td>";
                            echo "<td>
                                <a href='comments.php?do=Edit&comid=" . $com['C_ID']  . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                <a href='comments.php?do=Delete&comid=" . $com['C_ID']  . "' class='confirm btn btn-danger'><i class='fa fa-close'></i> Delete</a>";

                                if ($com['Status'] == 0) {
                                    echo "<a href='comments.php?do=Approve&comid=" . $com['C_ID']  . "' 
                                    class='btn btn-info active'>
                                    <i class='fa fa-check'></i> 
                                    Approve</a>";
                                }
                            echo "</td>";
                        echo "</tr>";
                    } 
                    ?>
                    </table>
                </div>
            </div>
            <?php } else {
                echo '<div class="container">';
                    echo "<div class='nice-message'>There's No Comments To Show</div>";
                echo '</div>';
            } 
            ?>

    <?php   
            } elseif ($do == 'Edit') { //Edit Page 

                    /*
                    *=============================================
                    *== Short If Code
                    *== Check If Get Request com_id Is Numeric & Get The Integer Value Of It
                    *=============================================
                    */
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

                /**
                * =====================================================
                *== Select All Data Depend On This Id
                * =====================================================
                */

                $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ? LIMIT 1");
                // Execute Query
                $stmt->execute(array($comid));
                // Fetch The Data
                $com = $stmt->fetch();

                // The Row Count 
                $count = $stmt->rowCount();

                // If There Is Such Id Show The Form
                if ($count > 0) { //echo 'Good This Is The Form';

                    // <!-- Just For Fun -->

                    echo '<h1 class="h1" class="text-center">Edit Comment</h1>';
                    echo '<div class="container">';
                    ?>

                        <form class="form-horizontal" action="comments.php?do=Update" method="POST">   
                            <input type="hidden" name="comid" value="<?php echo $comid ?>"> 
                            <!-- Start Username Field--> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Username</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                            <textarea class="form-control" name="comment">
                                <?php echo $com['Comment']; ?>
                            </textarea>
                        </div>
                        <div>
                            <span>===============================================</span>
                        </div>
                            <!-- End Username Field--> 


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

        } elseif ($do == 'Update') {    // Update Page
        
            echo "<h1 class='h1' class='text-center'>Update Comments</h1>";
            echo '<div class="container">';

        
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variables From The Form
                $comid        = $_POST['comid'];
                $comment   = $_POST['comment'];

                // Update The DataBase With This Info
                $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = $comid");
                $stmt->execute(array($comment));

                // Echo the Success Message
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";

                redirectHome2($theMsg, 'Back', 4);

            } else {

                echo 'Sorry Buddy You Cant Browse This Page Directly';

            }
        ?> 
            </div>
        <?php
        } elseif ($do == 'Delete') {   // Delete Comments Page 

                // echo 'Welcome To Delete Page';

                echo "<h1 class='h1' class='text-center'>Delete Comment</h1>";
                echo "<div class='container'>";


                // Check If Get Request comid Is Numeric & Get The Integer Value Of It
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

                $check = checkItem("C_ID", "comments", $comid);
   
                if ($check > 0) {

                    $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zid");

                    $stmt->bindParam(":zid", $comid);

                    $stmt->execute();

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";

                    redirectHome2($theMsg, 'Back', 4);

                } else {

                    $theMsg =  '<div class="alert alert-danger">Sorry Buddy This ID is Not Exist</div>';

                    redirectHome2($theMsg);


                }
                echo "</div>";  
        } elseif ($do = 'Activate') {  // Activate Members Page 


            echo "<h1 class='h1' class='text-center'>Approve Comment</h1>";
            echo "<div class='container'>";


            // Check If Get Request comid Is Numeric & Get The Integer Value Of It
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;


            $check = checkItem("C_ID", "comments", $comid);

            if ($check > 0) {

                $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID = $comid");

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Comment Approved</div>";

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
