<?php 
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    // print_r($_SESSION);
    // echo '<br>';
    if (isset($_SESSION['Username'])){
        header('Location: dashboard.php');     // Redirect To DashBoard Page
    }
    include 'init.php';

    // include  'layout/css/backend.css';   Wrong Path


    // Check If User Coming From HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // echo '<br>' . $hashedPass;
        // echo '<br>' .$username . ' ' . $password;

        // Check If The User Exist In DataBase

        $stmt = $con->prepare("SELECT 
                                    UserID, Username, Password 
                                FROM 
                                    users
                                WHERE
                                    Username = ?   
                                AND 
                                    Password = ? 
                                AND 
                                    GroupID = 1
                                LIMIT 1");
        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // If Count > 0 This Mean The DataBase Contain Record About This Username
        // echo $count;

        if ($count > 0) {
            // echo '<br>' . 'Welcome ' . $username;
            // print_r($row);

            $_SESSION['Username'] = $username;     // Register Session Name
            $_SESSION['ID'] = $row['UserID'];     // Register Session ID
            header('Location: dashboard.php');     // Redirect To DashBoard Page
            exit();   
        }
    }
?>



    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <h4>Admin Form</h4>
        <input class="form-control" type="text" name="user" id="" placeholder="Username" autocomplete="off" />
        <input class="form-control" type="password" name="pass" id="" placeholder="Password" autocomplete="new-password" />
        <input class="btn btn-primary btn-block" type="submit" value="Login" />
    </form>

<?php include $tpl . 'footer.php'; ?>