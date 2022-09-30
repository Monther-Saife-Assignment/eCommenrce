<?php 
    session_start();
    $pageTitle = 'Login';

    if (isset($_SESSION['user'])){
       header('Location: index.php');     // Redirect To index Page
    }

    include 'init.php'; 

     // Check If User Coming From HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['login'])) {

            // Login
        
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $hashedPass = sha1($pass);
            // echo '<br>' . $hashedPass;
            // echo '<br>' .$user . ' ' . $pass;

            // Check If The User Exist In DataBase
            $stmt = $con->prepare("SELECT 
                                        UserID, Username, Password 
                                    FROM 
                                        users
                                    WHERE
                                        Username = ?   
                                    AND 
                                        Password = ?");

            $stmt->execute(array($user, $hashedPass));

            $get = $stmt->fetch();

            $count = $stmt->rowCount(); 

            if ($count > 0) {

                $_SESSION['user'] = $user;     // Register Session Name
                // print_r($_SESSION);
                $_SESSION['uid'] = $get['UserID']; // Here We Get the UserID And Store it As A session

                header('Location: index.php');     // Redirect To DashBoard Page

                exit();
            }

        } else {

            // Sign Up
            // echo $_POST['username'];
            // $test =  $_POST['username'];

            $formErrors = array();

            // Assigning Values To Variables
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password2 = $_POST['password-again'];
            $email = $_POST['email'];

            if(isset($username)){
                // Try This :::===> <script>Musa</script>
                $filteredUser = filter_var($username, FILTER_SANITIZE_STRING); // It Is Working So Don't Worry
                // echo $filteredUser;
                
                if(strlen($filteredUser) < 4) {
                    $formErrors[] = 'User Name Must More Than 4 char';
                }
            }

            if(isset($password) && isset($password2)){

                if (empty ($password) || empty($password2) ) {

                    $formErrors[] = 'Sorry "Password Can\'t Be Empty"';

                }
                // echo '<p>' . sha1($_POST['password']) . '</p>';
                // echo '<p>' . sha1($_POST['password-again']) . '</p>';

                // $pass1 = sha1($_POST['password']);
                // $pass2 = sha1($_POST['password-again']);

                if (sha1($password) !== sha1($password2) ){

                    $formErrors[] = 'Sorry "Passwords Must Be Identical"';

                }
            }

            if(isset($email)){

                $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL); // It Is Working So Don't Worry
                // echo $filteredEmail;
                
                if(filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true ) {

                    $formErrors[] = 'Sorry "This Email Is Not Valid"';

                }
            }

            if (empty($formErrors)) {

                // Check If User Exist In DataBase Or Not
                $check = checkItem("Username", "users", $username);

                if ($check == 1) {

                    $formErrors[] =  'Sorry This User Is Exist';

                } else {

                    // Adding A New User To the Data Base
                    $stmt = $con->prepare("INSERT INTO 
                                                users(Username, Password, Email, RegStatus, Date)
                                            VALUES (:zuser, :zpass, :zmail, 0, now())");
                    
                    // $now = now();
                    $stmt->execute(array(

                        'zuser' => $username, 
                        'zpass' => sha1($password), 
                        'zmail' => $email, 

                    ));    

                    $successMsg =  "You Are Registered";
                }


            }   
        }
    }
?>

    <div class="background">
        <div class="container login-page">
            <h1 class="h1 text-center">
                <span class="selected" data-class="login">Login</span> | 
                <span data-class="signup">Signup</span>
            </h1>
            <!-- Start Login Form -->
            <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-container">
                    <input 
                        class="form-control" 
                        type="text" 
                        name="username" 
                        autocomplete="off" 
                        placeholder="Type Your User Name"
                        required = "required"/>
                </div>
                <div class="input-container">
                    <input 
                        class="form-control"  
                        type="password" 
                        name="password" 
                        autocomplete="new-password" 
                        placeholder="Password Must Be Complex"
                        required = "required" />
                    <input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
                </div>
            </form>
            <!-- End Login Form -->

            <!-- Start signUp Form -->
            <!-- pattern = ".{4,8}" Between 4 To 8 -->
            <form action="" class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-container">
                    <input 
                        pattern = ".{4,}"
                        title="Username Must Be More Than 3 Characters"
                        class="form-control" 
                        type="text" 
                        name="username" 
                        autocomplete="off" 
                        placeholder="Type Your User Name"
                         />
                </div>
                <div class="input-container">
                    <input 
                        minlength="4"
                        class="form-control"  
                        type="password" 
                        name="password" 
                        autocomplete="new-password" 
                        placeholder="Password Must Be Complex" 
                         />
                </div>
                <div class="input-container">
                    <input 
                        minlength="4"
                        class="form-control"  
                        type="password" 
                        name="password-again" 
                        autocomplete="new-password" 
                        placeholder="The Same Password Again"
                         />
                </div>
                <div class="input-container">
                    <input class="form-control"  
                            type="email" 
                            name="email" 
                            autocomplete="off" 
                            placeholder="Type A Valid Email" 
                             />
                </div>
                <input class="btn btn-success btn-block" name="Signup" type="submit" value="Signup" />
            </form>
            <!-- End signUp Form -->
            <div class="the-errors text-center">
                <?php
                     // echo $test; 
                    // echo $filteredUser;

                    if (!empty($formErrors)){

                        foreach($formErrors as $error) {
                            echo '<div class="msg">';
                            echo '<p>' . $error . '</p>';
                            echo '</div>';
                        }
                    }

                    // if (isset($error)) { I Used The Form Error Instead

                    //     echo '<div class="msg">' . $error. '</div>';

                    // }

                    if (isset($successMsg)) {
                        echo '<div class="msg success">' . $successMsg. '</div>';
                    }
                ?>
            </div>  
        </div>
    </div>

<?php include $tpl . 'footer.php'; ?>
