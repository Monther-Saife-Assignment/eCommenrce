<?php
    ob_start(); // Important -> To Fix Header Error 
    session_start();

    // $noNavbar = '';
    $pageTitle = 'categories';


    /**
     * ==================================================
     * == Menage Members Page
     * == You Can Add | Edit | Delete Members From Here
     * ==================================================
     */

    if (isset($_SESSION['Username'])){

        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start category Page 
        if ($do == 'Manage') { 
            
            // echo 'Hello';
            $sort = 'ASC';

            $sort_array = array('ASC', 'DESC');

            if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
                $sort = $_GET['sort'];  
            }


            $stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent = 0 ORDER BY `Ordering` $sort");

            $stmt2->execute();

            $cats = $stmt2->fetchAll();
            
            if (! empty($cats)) {
            ?>

            <h1 class="h1" class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i> Manage Categories
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i> Ordering:
                            [<a class="<?php if ($sort == 'ASC') { echo 'active'; } ?>" href="?sort=ASC">ASC</a> | 
                            <a class="<?php if ($sort == 'DESC') { echo 'active'; } ?>" href="?sort=DESC">DESC</a>  ]
                            <i class="fa fa-eye"></i> View:  [
                            <span class="active" data-view="full">Full</span>  |  
                            <span data-view="classic">Classic</span>  ]
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                            foreach($cats as $cat) {

                                echo "<div class='cat'>";
                                    echo "<div class='hidden-button'>";
                                        echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                        echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
                                    echo "</div>";
                                    echo "<h3>" . $cat['ID'] . "_ " . $cat['Name'] . "</h3>";
                                    echo '<div class="full-view">';
                                        echo "<p>";   
                                            $desc = ($cat['Description'] == '') ? 'This Is Empty' : $cat['Description']; 
                                            echo $desc;
                                        echo "</p>";

                                        if ($cat['Visibility'] == 1) { echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>'; }
                                        if ($cat['Allow_Comment'] == 1) { echo '<span class="commenting"><i class="fa fa-close"></i> Comment Disabled</span>'; }
                                        if ($cat['Allow_Ads'] == 1) { echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disabled</span>'; }

                                        // $categories = getCats(); UnUsed Function...
                                        $childCats = getAllFromV2("*", "categories", "WHERE Parent = {$cat['ID']}", "", "ID", "ASC");
                                        if (!empty($childCats)){
                                            echo "<h4 class='child-head'>Child Categories</h4>";
                                            echo "<ul class='list-unstyled child-cats'>";
                                            foreach($childCats as $c) {
                                                echo "<li class='show-link'>
                                                    <a href='categories.php?do=Edit&catid=" . $c['ID'] . "'>" . $c['Name'] . "</a>
                                                    <a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='confirm show-delete'> Delete</a>
                                                </li>";
                                            }
                                            echo "</ul>";
                                        }
                                    echo '</div>';
                                echo "</div>";
                                echo "<hr>";

                                                // '<li>
                                                //     <a href="categories.php?pageid=' . $c['ID'] . '">
                                                //         ' . $c['Name'] . '
                                                //     </a>
                                                // </li>';


                                    // Printing Out Some DATA Unorganized Way
                                // echo $cat['Name'] . '<br/>';
                                // echo $cat['Description'] . '<br/>';
                                // echo 'Ordering is => ' . $cat['Ordering'] . '<br/>';
                                // echo 'Visibility is => ' . $cat['Visibility'] . '<br/>';
                                // echo 'Allow_Comments is => ' . $cat['Allow_Comment'] . '<br/>';
                                // echo 'Allow_Ads is => ' . $cat['Allow_Ads'] . '<br/>';

                                // Long If Code
                                // echo '<p>' . if ($cat['Description'] == '') { echo 'This Is Empty'; }else { echo $cat['Description']; } echo '</p>';
                            }
                        ?>
                    </div>
                </div>
                <a href="categories.php?do=add" class="add-category btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New Category</a>
            </div>
            <?php } else {
                echo '<div class="container">';
                    echo "<div class='nice-message'>
                        There\'s No Categories To Show
                        </div>";
                    echo'<a href="categories.php?do=add" class="add-category btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New Category</a>';

                echo '</div>';
            } 
            ?>
            <?php
        } elseif($do == 'add') {

            // Add category Page?>


            <!-- // echo "Welcome To Add category Page"; -->
            <h1 class="h1" class="text-center">Add New category</h1>
            <div class="container">

                <form class="form-horizontal" action="categories.php?do=Insert" method="POST"> 

                        <!-- Start Name Field --> 
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for="">Name</label>
                        <div class="col-sm-10 col-md-offset-2 col-md-4">
                            <input type="text" name="name" class="form-control"
                            autocomplete="off" required="required" placeholder="Name Of The Category"/>
                        </div>
                    </div>
                        <!-- End Name Field--> 

                        <!-- Start Description Field --> 
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for="">Description</label>
                        <div class="col-sm-10 col-md-offset-2 col-md-4">
                            <input type="text" name="description" class="form-control"
                            autocomplete="off" placeholder="Description Of The Category"/>
                            <!-- required="required" -->
                        </div>
                    </div>
                        <!-- End Description Field--> 

                        <!-- Start Ordering Field --> 
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for="">Ordering</label>
                        <div class="col-sm-10 col-md-offset-2 col-md-4">
                            <input type="text" name="ordering" class="form-control"
                            autocomplete="off" placeholder="Number To Arrange  The Category"/>
                        </div>
                    </div>
                        <!-- End Ordering Field--> 

                        <!-- Start Category Type Field --> 
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for="">Category Type?</label>
                        <div class="col-sm-10 col-md-offset-2 col-md-4">
                            <select name="parent">
                                <option value="0">None</option>
                                <?php
                                    $allCats = getAllFromV2("*", "categories", "WHERE Parent = 0", "", "ID", 'DESC');
                                    foreach($allCats as $cat) {
                                        echo "<option value=" . $cat['ID'] . ">" . $cat["Name"] .  "</option>";
                                    }

                                ?>
                            </select>
                        </div>
                    </div>
                        <!-- End Category Type Field--> 

                    <!-- <div class="row"> -->
                            <!-- Start Visibility Field --> 
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="">Visibility</label>
                            <div class="col-sm-10 col-md-offset-2 col-md-4">
                                <div>
                                    <input id="vis-yes" type="radio" name="visibility" value="0" checked/>
                                    <label for="vis-yes">Yes</label>
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-offset-2 col-md-4">
                                <div>
                                    <input id="vis-no" type="radio" name="visibility" value="1"/>
                                    <label for="vis-np">No</label>
                                </div>
                            </div>
                            <!-- End Visibility Field --> 

                            <!-- Start Allow_Comments Field --> 
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="">Allow_Commenting</label>
                            <div class="col-sm-10 col-md-offset-2 col-md-4">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" checked/>
                                    <label for="com-yes">Yes</label>
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-offset-2 col-md-4">
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1"/>
                                    <label for="com-np">No</label>
                                </div>
                            </div>
                            <!-- End Allow_Comments Field --> 
                            <!-- Start Allow_Ads Field --> 
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="">Allow_Ads</label>
                            <div class="col-sm-10 col-md-offset-2 col-md-4">
                                <div>
                                    <input id="com-yes" type="radio" name="ads" value="0" checked/>
                                    <label for="com-yes">Yes</label>
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-offset-2 col-md-4">
                                <div>
                                    <input id="com-no" type="radio" name="ads" value="1"/>
                                    <label for="com-np">No</label>
                                </div>
                            </div>
                            <!-- End Allow_Ads Field --> 
                        <!-- </div> -->

                            <!-- Start Add Category--> 
                        <div class="form-group">
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Category" class="btn btn-primary" />
                        </div>
                        <!-- End Add Category--> 
                </form>
            </div>

<?php   } elseif ($do == 'Insert') { //Insert categories Page 

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo '<h1 class="h1" class="text-center">Insert Category</h1>';
                echo '<div class="container">';

                // Get Variables From The Form
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $order      = $_POST['ordering'];
                $parent       = $_POST['parent'];

                $visible    = $_POST['visibility'];
                $comment    = $_POST['commenting'];
                $ads        = $_POST['ads'];

                // Check If Category Exist In DataBase Or Not
                $check = checkItem("name", "categories", $name);

                if ($check == 1) {

                    $theMsg = '<div class="alert alert-danger">Sorry This Category Is Exist</div>';
                    redirectHome2($theMsg, "Back");

                } else {

                    // Insert Category Info To The DataBase 
                    $stmt = $con->prepare("INSERT INTO 
                            categories(Name, Description, parent, Ordering, Visibility, Allow_Comment, Allow_Ads)
                            VALUES (:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads)");
                    
                    $stmt->execute(array(
                        'zname'     => $name, 
                        'zdesc'     => $desc, 
                        'zorder'    => $order, 
                        'zparent'   => $parent,
                        
                        'zvisible'  => $visible,
                        'zcomment'  => $comment,
                        'zads'      => $ads
                    ));    

                    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted</div>";
                    redirectHome2($theMsg, 'Back');

                }
            } else {
                echo '<div class="container">';
                    $theMsg = '<div class="alert alert-danger error">Sorry Buddy You Cant Browse This Page Directly</div>';
                    redirectHome2($theMsg, 'Back', 6);
                echo '</div>';
            } 
        } elseif( $do == 'Edit') { 

            // Check If Get Request catid is Numeric & Get its Integer Value
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

            //Select All Data Depend On This Id
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

                // Execute Query
            $stmt->execute(array($catid));

            // Fetch The Data
            $cat = $stmt->fetch();

            // The Row Count 
            $count = $stmt->rowCount();

            // If There Is Such Id Show The Form
            if ($count > 0) {  ?>
    
                <h1 class="h1" class="text-center">Edit Category</h1>
                <div class="container">
        
                <form class="form-horizontal" action="categories.php?do=Update" method="POST"> 
                <input type="hidden" name="catid" value="<?php echo $catid ?>">

                <!-- Start Name Field --> 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Name</label>
                <div class="col-sm-10 col-md-offset-2 col-md-4">
                    <input type="text" name="name" class="form-control"
                    autocomplete="off" placeholder="Name Of The Category" value="<?php echo $cat['Name'] ?>"/>
                </div>
                </div>
                <!-- End Name Field--> 

                <!-- Start Description Field --> 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Description</label>
                <div class="col-sm-10 col-md-offset-2 col-md-4">
                    <input type="text" name="description" class="form-control"
                    autocomplete="off" placeholder="Description Of The Category" value="<?php echo $cat['Description'] ?>"/>
                    <!-- required="required" -->
                </div>
                </div>
                <!-- End Description Field--> 

                <!-- Start Ordering Field --> 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Ordering</label>
                <div class="col-sm-10 col-md-offset-2 col-md-4">
                    <input type="text" name="ordering" class="form-control"
                    autocomplete="off" placeholder="Number To Arrange  The Category" value="<?php echo $cat['Ordering'] ?>"/>
                </div>
                </div>
                <!-- End Ordering Field--> 
                <!-- Start Category Type Field --> 
                <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label" for="">Parent?_ <?php echo $cat['Parent']?></label>
                                <div class="col-sm-10 col-md-offset-2 col-md-4">
                                    <select name="parent">
                                        <option value="0">None</option>
                                        <?php
                                            $allCats = getAllFromV2("*", "categories", "WHERE Parent = 0", "", "ID", 'DESC');
                                            foreach($allCats as $c) {
                                                echo "<option value='" . $c['ID'] . "'";
                                                if($cat['Parent'] == $c['ID']) { echo ' selected'; }
                                                echo ">" . $c['Name'] .  "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                <!-- End Category Type Field--> 
                <!-- <div class="row"> -->
                    <!-- Start Visibility Field --> 
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for="">Visibility</label>
                    <div class="col-sm-10 col-md-offset-2 col-md-4">
                        <div>
                            <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0) {echo 'checked'; } ?>/>
                            <label for="vis-yes">Yes</label>
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-offset-2 col-md-4">
                        <div>
                            <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1) {echo 'checked'; } ?>/>
                            <label for="vis-np">No</label>
                        </div>
                    </div>
                    <!-- End Visibility Field --> 

                    <!-- Start Allow_Comments Field --> 
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for="">Allow_Commenting</label>
                    <div class="col-sm-10 col-md-offset-2 col-md-4">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) {echo 'checked'; } ?>/>
                            <label for="com-yes">Yes</label>
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-offset-2 col-md-4">
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1) {echo 'checked'; } ?>/>
                            <label for="com-np">No</label>
                        </div>
                    </div>
                    <!-- End Allow_Comments Field --> 
                    <!-- Start Allow_Ads Field --> 
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for="">Allow_Ads</label>
                    <div class="col-sm-10 col-md-offset-2 col-md-4">
                        <div>
                            <input id="com-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0) {echo 'checked'; } ?>/>
                            <label for="com-yes">Yes</label>
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-offset-2 col-md-4">
                        <div>
                            <input id="com-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1) {echo 'checked'; } ?>/>
                            <label for="com-np">No</label>
                        </div>
                    </div>
                    <!-- End Allow_Ads Field --> 
                <!-- </div> -->

                    <!-- Start Add Category--> 
                <div class="form-group">
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
                <!-- End Add Category--> 
                </form>
                </div>

                
            <?php 
            }else { 

                echo '<div class="container">';
                $theMsg = '<div class="alert alert-danger">Sorry Buddy There\'s No Such ID</div>';
                redirectHome2($theMsg, " ", 4);
                echo '</div>';
            }
        }elseif($do == 'Update') { 

            echo "<h1 class='h1' class='text-center'>Update Category</h1>";
            echo "<div class='container'>";

        
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Get Variables From The Form

                    $id         = $_POST['catid'];
                    $name       = $_POST['name'];
                    $desc       = $_POST['description'];
                    $order      = $_POST['ordering'];
                    $parent      = $_POST['parent'];
                    
                    $visible    = $_POST['visibility'];
                    $comment    = $_POST['commenting'];
                    $ads        = $_POST['ads']; 

                    // Update The DataBase With This Info

                    $stmt = $con->prepare("UPDATE 
                                                categories
                                            SET 
                                                Name = ?,
                                                Description = ?,
                                                Ordering = ?, 
                                                Parent = ?, 
                                                Visibility = ?, 
                                                Allow_Comment = ?, 
                                                Allow_Ads = ?
                                            WHERE 
                                                ID = $id");

                    $stmt->execute(array($name, $desc, $order, $parent, $visible, $comment, $ads));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";

                    redirectHome2($theMsg, 'Back', 4);

                } else {

                    echo 'Sorry Buddy You Cant Browse This Page Directly';

                    $errorMsg2 = 'Sorry Buddy You Cant Browse This Page Directly';
                    redirectHome2($errorMsg2, "Back");

                }
            echo "</div>";  //Close Container Div
            
        } elseif($do == 'Delete') {  

        
            // echo 'Welcome To Delete Category Page';

            echo "<h1 class='h1' class='text-center'>Delete Category</h1>";
            echo "<div class='container'>";

                // Check If Get Request catid Is Numeric & Get The Integer Value Of It
                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

                // Select All Data Depend On This Id
                $check = checkItem("ID", "categories", $catid);

                if ($check > 0) {

                    $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

                    $stmt->bindParam(":zid", $catid);

                    $stmt->execute();

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";

                    redirectHome2($theMsg, 'Back', 4);

                } else {

                    $theMsg =  '<div class="alert alert-danger">Sorry Buddy This ID is Not Exist</div>';

                    redirectHome2($theMsg, "Back");


                }
            echo "</div>"; 

        }
        
        include $tpl . 'footer.php';
    }else {

        header('Location: index.php');     // Redirect To index Page
        exit();

}