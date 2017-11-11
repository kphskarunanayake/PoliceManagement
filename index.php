<?php
    session_start();
    include_once ('./dbcon.php');
    
    $error = FALSE;
    if (isset($_POST['login'])){
        $email = trim($_POST['email']);
        $email = htmlspecialchars(strip_tags($email));
        
        $password = trim($_POST['password']);
        $password = htmlspecialchars(strip_tags($password));
        
        if(empty($email)){
            $error = TRUE;
            $errEmail = 'Please input email';
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = TRUE;
            $errEmail = 'Please enter a valid email address';
    }
    
    if (empty($password)){
        $error = TRUE;
        $errPassword = 'Please input password';
    }elseif (strlen($password)<6) {
        $error = TRUE;
        $errPassword = 'Please at least 6 characters';
    }
    
    if(!$error){
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        
        if ($count==1 && $row['password']==$password){
            $_SESSION['username'] = $row['username'];
            header('location: home.php');
        }  else {
            $errMsg = 'Invalid Username or Password';
        }
    }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/normalize.min.css">
    </head>
    <body>
        <div class="form">
            <ul class="tab-group">
                <li class="tab"><a href="#login">Log In</a></li>
            </ul>
            <?php
            if (isset($errMsg)){
                ?>
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-info-sign"></span>
                <?php echo $errMsg; ?>
            </div>
            <?php
            }
            ?>

            <div class="tab-content">
                <div id="login">
                    <h1>Welcome Back!</h1>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                        
                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email" required autocomplete="off" name="email"/>
                            <span class="text-danger"><?php if (isset($errEmail)) echo $errEmail; ?></span>
                        </div>

                        <div class="field-wrap">
                            <label>
                                Password<span class="req">*</span>
                            </label>
                            <input type="password" required autocomplete="off" name="password"/>
                            <span><?php if (isset($errPassword)) echo $errPassword; ?></span>
                        </div>

                        <p class="forgot"><a href="register.php">New User?</a></p>

                        <input type="submit" class="button button-block" name="login" />

                    </form>
                </div>
            </div>
        </div>
        <script src='js/jquery.min.js'></script>

        <script src="js/index.js"></script>
    </body>
</html>