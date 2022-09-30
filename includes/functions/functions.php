<?php


    /**
     * Get All Function v1.0
     * Function To Get All Fields From Any Database Table...
     */
    // This Is A Global Function And You Can Use It Every Where 
    function getAllFrom($tableName, $orderBy = NULL, $where = NULL) {

        global $con;
    
        // This Is The Short If Code 
        $sql = $where == NULL ? '' : $where;

        $getAll = $con->prepare("SELECT * FROM $tableName $sql ORDER BY $orderBy DESC");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;

            // This Is The Long If Code
        // if($where == NULL) {
        //     $sql = '';
        // } else {
        //     $sql = $where;
        // }
    }

    /**
     * Get All Function v2.0
     * Function To Get All Fields From Any Database Table...
     */
    // This Is A Global Function And You Can Use It Every Where 
    function getAllFromV2($field, $tableName, $where = NULL, $and = NULL, $orderField = NULL, $ordering = 'DESC') {

        global $con;

        $getAll = $con->prepare("SELECT $field FROM $tableName $where $and ORDER BY $orderField $ordering");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;

    }

    /**
     * Get Categories Records Function v1.0
     * Function To Get Categories From Database ...
     */

    function getCats() {

        global $con;

        $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

        $getCat->execute();

        $cats = $getCat->fetchAll();

        return $cats;
    }

    /**
     * Get Items Records Function v1.0
     * Function To Get Categories From Database ...
     */

    function getItems($catID) {

        global $con;

        $getItems = $con->prepare("SELECT * FROM items WHERE Cat_ID = ? ORDER BY item_ID DESC");

        $getItems->execute(array($catID));

        $items = $getItems->fetchAll();

        return $items;
    }

    /**
     * Get Items Records Function v2.0
     * Function To Get Categories $ Items From Database ...
     */

    function getItems2($where, $value) {

        global $con;

        $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY item_ID DESC");

        $getItems->execute(array($value));

        $items = $getItems->fetchAll();

        return $items;
    }

    /**
     * Get Add Items Records Function v3.0
     * Function To Get Categories $ Items From Database ...
     */

    function getAddItems($where, $value, $approve = NULL) {

        global $con;

        // Short If Code 
        $sql = ($approve == NULL) ? 'AND Approve = 1' : NULL;

        // Long If Code
        // if($approve == NULL) {
        //     $sql = 'AND Approve = 1';
        // } else {
        //     $sql = '';
        // }

        $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql  ORDER BY item_ID DESC");

        $getItems->execute(array($value));

        $items = $getItems->fetchAll();

        return $items;
    }

    
    /**
     * Check If user Is Not Activated
     * Function To Check The RegStatus Of The User
     */

    function checkUserStatus($user) {

        global $con;

        $stmtX = $con->prepare("SELECT 
                                    Username, RegStatus 
                                FROM 
                                    users
                                WHERE
                                    Username = ?   
                                AND 
                                RegStatus = 0 ");

        $stmtX->execute(array($user));

        $status = $stmtX->rowCount();

        return $status;
    }


    // echo 'Functions Is Here';

    /**
     *  Title Function V1.0
     *  That Echo The (Page Title) In Case The Page 
     *  Has The Variable ($pageTitle) And Echo (Default Title) 
     *  For Other Pages 
     */

    function getTitle() {

        global $pageTitle;

        if(isset($pageTitle)) {
            echo $pageTitle;
        }else {
            echo lang('DEFAULT');
        }

    }

    /**
     * Check Items Functions V1.0
     * Function To Check Items In DataBase (Function Accept Parameters)
     * $select = The Item To Select [ Examples: user, item, category ]
     * $form =  The Table To Select From [ Example: users, items, categories ]
     * $value = The Value Of Select [ Example: Ahmed, Box, Electronics]
     */

    function checkItem($select, $from, $value) {

        global $con;

        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

        $statement->execute(array($value));

        $count = $statement->rowCount();

        // echo $count;  It Will Always Print Number 1

        return $count;  // Return Will Store Number 1 Without Printing It

    }

























    






    /**
     * Redirect Function V1.0
     * This Function Accept Parameters
     * $errorMsg = Echo The Error Message
     * $seconds = Seconds Before Redirecting
     */

    function redirectHome($errorMsg, $seconds = 3) {

        header('refresh:' . $seconds . '; url="dashboard.php"');

        echo "<div class='alert alert-danger'>$errorMsg</div>";

        echo "<div class='alert alert-info'>You Will Be Redirected To Home Page After $seconds Seconds</div>";

        exit();

    }

    //=========================================

    /**
     * Redirect Function V2.0
     * This Function Accept Parameters
     * $theMsg = Echo The Message [ Error | Success | Warning ]
     * $url = The Link You Want To Redirect To
     * $seconds = Seconds Before Redirecting
     */

    function redirectHome2($theMsg, $url= null, $seconds = 4) {

        if ($url == null) {

            $url = 'dashboard.php';
            $link = 'Home Page';

        } else {
            // Short IF...
            // $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'dashboard.php';

            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'Previous Page';

            } else {

                $url = 'dashboard.php';
                $link = 'Home Page';

            }

        }

        echo $theMsg;

        echo "<div class='alert alert-info'>You Will Be Redirected To  $link After $seconds Seconds</div>";

        header("refresh: $seconds;url=$url");

        // ob_start();
        // header('refresh:$seconds;url=***-----$url--OR');
        // ob_end_flush();
    
        exit();

    }

    //=========================================

    /**
     * Redirect Function V2.0
     * This Function Accept Parameters
     * $theMsg = Echo The Message [ Error | Success | Warning ]
     * $url = The Link You Want To Redirect To
     * $seconds = Seconds Before Redirecting
     */

    // function redirectHome2($theMsg, $url= null, $seconds = 3) {
        // On Feature
    //     if ($url == null) {

    //         $url = 'dashboard.php';

    //         $link = 'Home Page';

    //     } else {

    //         $url = 'dashboard.php';

    //         $link = 'Previous Page';

    //     }

    //     header('refresh:' . $seconds . '; url= ' . $url);

    //     echo $theMsg;

    //     echo "<div class='alert alert-info'>You Will Be Redirected To  $link After $seconds Seconds</div>";

    //     exit();

    // }

    // Today We Are Going To Create A Simple Function..
    // That Deal With The DataBase...
    // To Check If That The User Exist Or Not.




    /**
     * Count Number Of Items Function v1.0
     * Function To Count Number Of Items Rows
     * $item = The Items To Count
     * $table = The Table To Choose From
     * 
     */

    function countItems($item, $table) {

        global $con;

        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

        $stmt2->execute();

        return $stmt2->fetchColumn();

    }
    

    /**
     * Get Latest Records Function v1.0
     * Function To Get Latest Items From Database [ Users, Items, Comments ]
     * $select = Field To Select
     * $table = The Table To Choose From
     * $order = The DESC Ordering 
     * $limit = Number Of Records To Get
     */

    function getLatest($select, $table, $order, $limit) {

        global $con;

        $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

        $getStmt->execute();

        $rows = $getStmt->fetchAll();

        return $rows;
    }