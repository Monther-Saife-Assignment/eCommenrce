<?php
    
    /**
     * ==================================================
     * == Template Page
     * ==================================================
     */
    ob_start(); // Important -> To Fix Header Error 
    session_start();

    // $noNavbar = '';
    $pageTitle = 'Items';

    if (isset($_SESSION['Username'])){

        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page 
        if ($do == 'Manage') { 

            // echo 'Welcome To Items Page';

            // Select All Items Except Admin 
            $stmt = $con->prepare("SELECT items.* , 
                                            categories.Name as Category_Name,
                                            users.Username as Clint_Name 
                                    FROM 
                                        items
                                    INNER JOIN 
                                        categories ON categories.ID = items.Cat_ID
                                    INNER JOIN 
                                        users ON users.UserID = items.Member_ID
                                    ORDER BY 
                                        item_ID DESC");
    
                // Execute The Statement
            $stmt->execute();
            
            // Assign To Variable
            $items = $stmt->fetchAll();
            
            if (! empty ($items)) {
            ?>          
    
                <h1 class="h1" class="text-center">Manage Items</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                        
                            <tr>
                                <td>#ID</td> 
                                <td>Name</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Add_Date</td>
                                <td>Category</td>
                                <td>Member</td>
                                <!-- <td>Country</td> -->
                                <td>Control</td>
                            </tr>
                    <?php
                        foreach($items as $item) {
    
                            echo "<tr>";
                                echo "<td>" . $item['item_ID'] . "</td>";
                                echo "<td>" . $item['Name'] . "</td>";
                                echo "<td>" . $item['Description'] . "</td>";
                                echo "<td>" . $item['Price'] . "</td>";
                                echo "<td>" . $item['Add_Date'] . "</td>";
                                echo "<td>" . $item['Category_Name'] . "</td>";
                                echo "<td>" . $item['Clint_Name'] . "</td>";
                                // echo "<td>" . $item['Country_Made'] . "</td>";
                                echo "<td>
                                    <a href='items.php?do=Edit&itemid=" . $item['item_ID']  . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                    <a href='items.php?do=Delete&itemid=" . $item['item_ID']  . "' class='confirm btn btn-danger'><i class='fa fa-close'></i> Delete</a>";
                                    if ($item['Approve'] == 0) {
                                        echo "<a 
                                        href='items.php?do=Approve&itemid=" . $item['item_ID']  . "' 
                                        class='btn btn-info active'>
                                        <i class='fa fa-check'></i> Approve</a>";
    
                                    }

                                echo "</td>";
                            echo "</tr>";
    
                        } 
                    ?>
                        </table>
                    </div>
                    <a href="items.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i> Add New Item</a>
                </div>

                <?php } else {

                    echo '<div class="container">';
                        echo "<div class='nice-message'>There's No Items To Show</div>";
                        echo '<a href="items.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i> Add New Item</a>';
                    echo '</div>';

                }?>

<?php    } elseif ($do == 'Add') {  // echo "Welcome To Add Items Page";?>

            <h1 class="h1" class="text-center">Add New Item</h1>
            <div class="container">

                <form class="form-horizontal" action="items.php?do=Insert" method="POST"> 

                    <!-- Start Name Field--> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Name</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control cont" 
                        placeholder="Name Of The Item"/>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Name Field--> 

                    <!-- Start Description Field--> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Description</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <input 
                        type="text" 
                        name="description" 
                        class="form-control cont" 
                        placeholder="Description Of The Item"/>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Description Field--> 

                    <!-- Start Price Field--> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Price</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <input 
                        type="text" 
                        name="price"
                        class="form-control cont" 
                        placeholder="Price Of The Item"/>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Price Field--> 

                    <!-- required="required" -->
                    <!-- Start Country Field--> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Country</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <input 
                        type="text" 
                        name="country" 
                        class="form-control cont" 
                        placeholder="Country Of Made"/>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Country Field--> 

                    <!-- Start Status Field--> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Status</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <select class="form-control cont" name="status">
                        <option value="0">...</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Very Old</option>
                    </select>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Status Field--> 

                    <!-- Start Members Field--> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Member</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <select class="form-control cont" name="member">
                        <option value="0">...</option>
                        <?php
                            $allMembers = getAllFromV2("*", "users", "", "", "UserID", "ASC");
                            
                            // The Above Function Will Handel Every Thing
                            // $stmt = $con->prepare("SELECT * FROM users");
                            // $stmt->execute();
                            // $users = $stmt->fetchAll();

                            foreach($allMembers as $user) {
                                echo "<option value='" . $user['UserID'] . "'>" . $user['Username']. "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Members Field--> 

                    <!-- Start Categories Field--> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Category</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <select class="form-control cont" name="category">
                        <option value="0">...</option>
                        <?php
                            $allCats = getAllFromV2("*", "categories", "WHERE Parent = 0", "", "ID", "ASC");

                            // The Above Function Will Handel Every Thing
                            // $stmt2 = $con->prepare("SELECT * FROM categories");
                            // $stmt2->execute();
                            // $cats = $stmt2->fetchAll();

                            foreach($allCats as $cat) {
                                echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";

                                 // $categories = getCats(); UnUsed Function...
                                $childCats = getAllFromV2("*", "categories", "WHERE Parent = {$cat['ID']}", "", "ID", "ASC");
                                if (!empty($childCats)){
                                    foreach($childCats as $c) {
                                        echo "<option value='" . $c['ID'] . "'>--- " . $c['Name'] . " From=> " . $cat['Name'] .  "</option>";
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Categories Field--> 

                    <!-- Start Tags Field--> 
                    <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Tags</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <input 
                        type="text" 
                        name="tags" 
                        class="form-control cont" 
                        placeholder="Separate Tags With Comma"/>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    <!-- End Tags Field--> 

                    <!-- Start Rating Field ==> Its Better To Be From User
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="">Rating</label>
                </div>
                <div class="col-sm-offset-2 col-sm-7">
                    <select class="form-control cont" name="rating">
                        <option value="0">...</option>
                        <option value="1">*</option>
                        <option value="2">**</option>
                        <option value="3">***</option>
                        <option value="4">****</option>
                        <option value="5">*****</option>
                    </select>
                </div>
                <div>
                    <span>===============================================</span>
                </div>
                    End Rating Field--> 

                    <!-- Start Submit Field--> 
                <div class="form-group">
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                </div>
                    <!-- End Submit Field--> 
                </form>
            </div>
<?php
        } elseif ($do == 'Insert') {

            // echo 'Welcome To Insert Page';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo '<h1 class="h1" class="text-center">Insert Item</h1>';
                echo '<div class="container">';

                // Get Variables From The Form
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['status'];
                $member     = $_POST['member'];
                $cat        = $_POST['category'];
                $tags        = $_POST['tags'];


                // Validate The Form
                $formErrors = array();
    
                if (empty($name)) {
                    $formErrors[] = 'Name Can\'t Be <strong>Empty</strong>';
                }

                if (empty($desc)) {
                    $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
                }               

                if (empty($price)) {
                    $formErrors[] = 'Price Can\'t Be <strong>Empty</strong>';
                }

                if (empty($country)) {
                    $formErrors[] = 'Country Can\'t Be <strong>Empty</strong>';
                }

                if ($status == 0) {
                    $formErrors[] = 'You Must Choose The <strong>Status</strong>';
                }

                if ($cat == 0) {
                    $formErrors[] = 'You Must Choose The <strong>Category</strong>';
                }

                if ($member == 0) {
                    $formErrors[] = 'You Must Choose The <strong>Member</strong>';
                }

                // Loop Into Error Array And Echo It
                foreach($formErrors as $error) {                      
                    // Echo Success Message
                    echo  '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check If There Is No Error Proceed The Update Operation
                if (empty($formErrors)) {

                    // Insert User Info To The DataBase 
                    $stmt = $con->prepare("INSERT INTO 
                                            items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, Tags)
                                            VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");
                    
                    $stmt->execute(array(

                        'zname'     => $name, 
                        'zdesc'     => $desc, 
                        'zprice'    => $price, 
                        'zcountry'  => $country,
                        'zstatus'   => $status,
                        'zmember'   => $member,
                        'zcat'      => $cat,
                        'ztags'     => $tags

                        ));    

                    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted</div>";
                    redirectHome2($theMsg, 'Back');
                }

            } else {
                echo '<div class="container">';

                    $theMsg = '<div class="alert alert-danger error">Sorry Buddy You Cant Browse This Page Directly</div>';

                    redirectHome2($theMsg, 'Back', 4);

                echo '</div>';
            }
        
            echo'</div>';
        } elseif ($do == 'Edit') {

            /*
            *=============================================
            *== Short If Code
            *== Check If Get Request itemid Is Numeric & Get The Integer Value Of It
            *=============================================
            */
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                //Select All Data Depend On This Id
            $stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");

            // Execute Query
            $stmt->execute(array($itemid));

            // Fetch The Data
            $item = $stmt->fetch();

                // The item Count 
            $count = $stmt->rowCount();

                // If There Is Such Id Show The Form
            if ($count > 0) { //echo 'Good This Is The Form';
    
                // <!-- Just For Fun -->

                echo '<h1 class="h1" class="text-center">Edit Item</h1>';
                echo '<div class="container">';
                ?>

                    <form class="form-horizontal" action="items.php?do=Update" method="POST"> 
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>">  <!--$itemid  &  $item['item_ID']-->

                        <!-- Start Name Field--> 
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Name</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control cont" 
                            value="<?php echo $item['Name']?>"
                            placeholder="Name Of The Item"/>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Name Field--> 

                        <!-- Start Description Field--> 
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Description</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <input 
                            type="text" 
                            name="description" 
                            class="form-control cont" 
                            value="<?php echo $item['Description']?>"
                            placeholder="Description Of The Item"/>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Description Field--> 

                        <!-- Start Price Field--> 
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Price</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <input 
                            type="text" 
                            name="price"
                            class="form-control cont" 
                            value="<?php echo $item['Price']?>"
                            placeholder="Price Of The Item"/>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Price Field--> 

                        <!-- required="required" -->
                        <!-- Start Country Field--> 
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Country</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <input 
                            type="text" 
                            name="country" 
                            class="form-control cont" 
                            value="<?php echo $item['Country_Made']?>"
                            placeholder="Country Of Made"/>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Country Field--> 

                        <!-- Start Status Field--> 
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Status</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <select class="form-control cont" name="status">
                            <!-- <option value="0">...</option> -->
                            <option value="1" <?php if ( $item['Status'] == 1 ) { echo 'selected';} ?>>New</option>
                            <option value="2" <?php if ( $item['Status'] == 2 ) { echo 'selected';} ?>>Like New</option>
                            <option value="3" <?php if ( $item['Status'] == 3 ) { echo 'selected';} ?>>Used</option>
                            <option value="4" <?php if ( $item['Status'] == 4 ) { echo 'selected';} ?>>Very Old</option>
                        </select>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Status Field--> 

                        <!-- Start Members Field--> 
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Member</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <select class="form-control cont" name="member">
                            <!-- <option value="0">...</option> -->
                            <?php
                                $editMembers = getAllFromV2("*", "users", "", "", "UserID", "ASC");

                                // The Function Will Handle Every Thing
                                // $stmt = $con->prepare("SELECT * FROM users");
                                // $stmt->execute();
                                // $users = $stmt->fetchAll();

                                foreach($editMembers as $user) {
                                    echo "<option value='" . $user['UserID'] . "'"; 
                                    if ( $item['Member_ID'] == $user['UserID']) { echo 'selected';} 
                                    echo ">" . $user['Username'] . "</option>";
                                }
                            ?>
                        </select>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Members Field--> 

                        <!-- Start Categories Field--> 
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Category</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <select class="form-control cont" name="category">
                            <option value="0">...</option>
                            <?php
                                $editCats = getAllFromV2("*", "categories", "", "", "ID", "ASC");

                                // The Function Will Handle Every Thing
                                // $stmt2 = $con->prepare("SELECT * FROM categories");
                                // $stmt2->execute();
                                // $cats = $stmt2->fetchAll();

                                foreach($editCats as $cat) {
                                    echo "<option value='" . $cat['ID'] . "'";
                                    if ( $item['Cat_ID'] == $cat['ID']) { echo 'selected';} 
                                    echo ">" . $cat['Name']. "</option>";
                                }
                            ?>
                        </select>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        <!-- End Categories Field--> 

                        <!-- Start Tags Field--> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Tags</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                            <input 
                                type="text" 
                                name="tags" 
                                value="<?php echo $item['Tags']?>"
                                class="form-control cont" 
                                placeholder="Separate Tags With Comma"/>
                        </div>
                        <div>
                            <span>===============================================</span>
                        </div>
                        <!-- End Tags Field-->

                        <!-- Start Rating Field ==> Its Better To Be From User
                        <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Rating</label>
                        </div>
                        <div class="col-sm-offset-2 col-sm-7">
                        <select class="form-control cont" name="rating">
                            <option value="0">...</option>
                            <option value="1">*</option>
                            <option value="2">**</option>
                            <option value="3">***</option>
                            <option value="4">****</option>
                            <option value="5">*****</option>
                        </select>
                        </div>
                        <div>
                        <span>===============================================</span>
                        </div>
                        End Rating Field--> 

                        <!-- Start Submit Field--> 
                        <div class="form-group">
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save" class="btn btn-primary btn-sm" />
                        </div>
                        <!-- End Submit Field--> 
                    </form>
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
                                                Item_ID = $itemid");

                    // Execute The Statement
                    $stmt->execute();
        
                    // Assign To Variable
                    $comments = $stmt->fetchAll();

                    if (! empty($comments)) {
                    ?>
                    <span>==============================================================================================</span>
                    <h1 class="h1" class="text-center">Manage (( <?php echo $item['Name']?> )) Comment</h1>
                        <div class="table-responsive">
                            <table class="main-table text-center table table-bordered">
                            
                                <tr>
                                    <td>Comment</td>
                                    <td>Member Name</td>
                                    <td>Added Date</td>
                                    <td>Control</td>
                                </tr>
                            <?php
                            foreach($comments as $com) {
                                echo "<tr>";
                                    echo "<td>" . $com['Comment'] . "</td>";
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
    
                    $theMsg = '<div class="alert alert-danger">Sorry Buddy There\'s No Such ID</div>';                
    
                    redirectHome2($theMsg, " ", 4);
                    echo '</div>';
                }
    
    
                    //==============================================================================
                    // print_r($_SESSION); 
                    // echo 'Welcome To Edit Page And Your Id Is ' . $_GET['userid'];
        
        } elseif ($do == 'Update') { 

            echo '<h1 class="h1" class="text-center">Update Item</h1>';
            echo '<div class="container">';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get Variables From The Form
            $id         = $_POST['itemid'];
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $price      = $_POST['price'];
            $country    = $_POST['country'];
            $status     = $_POST['status'];
            $member     = $_POST['member'];
            $cat        = $_POST['category']; 
            $tags        = $_POST['tags']; 


            // Validate The Form
            $formErrors = array();

            if (empty($name)) {
                $formErrors[] = 'Name Can\'t Be <strong>Empty</strong>';
            }

            if (empty($desc)) {
                $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
            }               

            if (empty($price)) {
                $formErrors[] = 'Price Can\'t Be <strong>Empty</strong>';
            }

            if (empty($country)) {
                $formErrors[] = 'Country Can\'t Be <strong>Empty</strong>';
            }

            if ($status == 0) {
                $formErrors[] = 'You Must Choose The <strong>Status</strong>';
            }

            if ($cat == 0) {
                $formErrors[] = 'You Must Choose The <strong>Category</strong>';
            }

            if ($member == 0) {
                $formErrors[] = 'You Must Choose The <strong>Member</strong>';
            }

            // Loop Into Error Array And Echo It
            foreach($formErrors as $error) {                      
                echo  '<div class="alert alert-danger">' . $error . '</div>';
            }

            // Check If There Is No Error Proceed The Update Operation
            if (empty($formErrors)) {

                // Update The DataBase With This Info
                $stmt = $con->prepare("UPDATE 
                                            items 
                                        SET 
                                            Name = ?, 
                                            Description = ?, 
                                            Price = ?, 
                                            Country_Made = ?, 
                                            Status = ?, 
                                            Member_ID = ?, 
                                            Cat_ID = ?,
                                            Tags = ?
                                        WHERE 
                                            item_ID = $id");

                $stmt->execute(array($name, $desc, $price, $country, $status, $member, $cat, $tags));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";
                redirectHome2($theMsg, 'Back', 4);
            }
            } else {

                echo 'Sorry Buddy You Cant Browse This Page Directly';

                // $errorMsg2 = 'Sorry Buddy You Cant Browse This Page Directly';
                // redirectHome($errorMsg2);

            }
        
            echo "</div>";

        } elseif ($do == 'Delete') { 
            
            // echo 'Welcome To Delete Page';

            echo "<h1 class='h1' class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";

              // Check If Get Request itemid Is Numeric & Get The Integer Value Of It
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

            $check = checkItem("item_ID", "items", $itemid);

               // Execute Query
            if ($check > 0) {

                $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zid");

                $stmt->bindParam(":zid", $itemid);

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";

                redirectHome2($theMsg, 'Back', 4);

            } else {

                $theMsg =  '<div class="alert alert-danger">Sorry Buddy This ID is Not Exist</div>';

                redirectHome2($theMsg);

            }
            echo "</div>";  
        } elseif ($do == 'Approve') { 

            // echo 'Activate';
            // echo 'Welcome To Activate Page';

            echo "<h1 class='h1' class='text-center'>Approve Item</h1>";
            echo "<div class='container'>";


            // Check If Get Request itemid Is Numeric & Get The Integer Value Of It
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;


            $check = checkItem("item_ID", "items", $itemid);

            if ($check > 0) {

                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = $itemid");

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Approved</div>";

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
