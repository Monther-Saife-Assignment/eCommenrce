<?php 

    session_start();  

    $pageTitle = 'Create New Item';

    include 'init.php';
    // As You See Here The Profile Page Depends On The Session
    
    // echo $sessionUser; We Will Count On This Session User
    if(isset($_SESSION['user'])) {

        // print_r($_SESSION); Here We Printed Put The Session Data

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $formErrors = array();

            $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $country    = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
            $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
            $category   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
            $tags       = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

            // echo $name; To Check The Filtering
            // echo $price; To Check The Filtering

            if (strlen($name) < 4) {
                $formErrors[] = 'Item Title Must Be At Least 4 Characters';
            }

            if (strlen($desc) < 10) {
                $formErrors[] = 'Item Desc Must Be At Least 10 Characters';
            }

            if (strlen($country) < 2) {
                $formErrors[] = 'Item Country Must Be At Least 2 Characters';
            }

            if (empty($price)) {
                $formErrors[] = 'Item Price Must Be Not Empty';
            }

            if (empty($status)) {
                $formErrors[] = 'Item status Must Be Not Empty';
            }

            if (empty($category)) {
                $formErrors[] = 'Item category Must Be Not Empty';
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
                    'zcat'      => $category,
                    'zmember'   => $_SESSION['uid'],
                    'ztags'      => $tags

                    ));    

                if($stmt) {
                    $done = 'Item Has Been Added';
                }
            }


        }


?>

    <h1 class="h1"><?php  echo $pageTitle ?></h1>

    <div class="create-ad block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading"><?php echo $pageTitle ?></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"> 

                                <!-- Start Name Field--> 
                                <div class="form-group">
                                <label class="col-sm-2 control-label" for="">Name</label>
                                </div>
                                <div class="col-sm-offset-2 col-sm-7">
                                <input 
                                    pattern=".{4,}"
                                    title="This Field Require At Least 4 Char"
                                    type="text" 
                                    name="name" 
                                    class="form-control cont live-name" 
                                    placeholder="Name Of The Item"
                                    required/>
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
                                    pattern=".{10,}"
                                    title="This Field Require At Least 10 Char"
                                    type="text" 
                                    name="description" 
                                    class="form-control cont live-desc" 
                                    placeholder="Description Of The Item"
                                    required/>
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
                                    class="form-control cont live-price" 
                                    placeholder="Price Of The Item"
                                    required/>
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
                                    placeholder="Country Of Made"
                                    required/>
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
                                <select class="form-control cont" name="status" required>
                                    <option value="">...</option>
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

                                <!-- Start Categories Field--> 
                                <div class="form-group">
                                <label class="col-sm-2 control-label" for="">Category</label>
                                </div>
                                <div class="col-sm-offset-2 col-sm-7">
                                <select class="form-control cont" name="category" required>
                                    <option value="">...</option>
                                    <?php
                                        // The Function Dose The Same Thing That Statements Dose
                                        // $stmt2 = $con->prepare("SELECT * FROM categories");
                                        // $stmt2->execute();
                                        // $cats = $stmt2->fetchAll();

                                        //  getAllFrom('categories', 'ID'); The Old Function
                                        $cats = getAllFromV2('*', 'categories', '', '', 'ID', 'ASC');
                                        foreach($cats as $cat) {
                                            echo "<option value='" . $cat['ID'] . "'>" . $cat['Name']. "</option>";
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

                                <!-- Start Submit Field--> 
                                <div class="form-group">
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                                </div>
                                <!-- End Submit Field--> 
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail item-box live-preview">
                                <span class="price-tag">$0</span>
                                <img src="info.jpg" alt="" /> 
                                <div class="caption">
                                    <h3>Title</h3>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                        if (!empty($formErrors)){

                            foreach($formErrors as $error) {
                                echo '<div class="alert alert-danger">' . $error . '</div>';
                            }
                        }

                        if (isset($successMsg)) {
                            echo '<div class="alert alert-success">' . $successMsg. '</div>';
                        }

                        if(isset($stmt)) {
                            echo '<div class="alert alert-success">' . $done . '</div>';
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