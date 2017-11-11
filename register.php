<?php
include_once './dbcon.php';

$error = FALSE;
if (isset($_POST['register'])) {

    //clean user input to prevent sql injection
    $regno = $_POST['regno'];
    $regno = strip_tags($regno);
    $regno = htmlspecialchars($regno);

    $pstation = $_POST['pstation'];
    $pstation = strip_tags($pstation);
    $pstation = htmlspecialchars($pstation);

    $username = $_POST['username'];
    $username = strip_tags($username);
    $username = htmlspecialchars($username);

    $email = $_POST['email'];
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = $_POST['password'];
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    //validate
    if (empty($regno)) {
        $error = TRUE;
        $errRegno = 'Please input username';
    }
    if (empty($pstation)) {
        $error = TRUE;
        $errPstation = 'Please input Police Station';
    }
    if (empty($username)) {
        $error = TRUE;
        $errUsername = 'Please input Username';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = TRUE;
        $errEmail = 'Please input valid Email';
    }
    if (empty($password)) {
        $error = TRUE;
        $errPassword = 'Please input password';
    } elseif (strlen($password) < 6) {
        $error = TRUE;
        $errPassword = 'Password must at least 6 characters';
    }
    
    //encrypt
    $password = md5($password);
    
    //insert data
    if(!$error){
        $sql = "INSERT INTO users(regno,pstation,username,email,password) VALUES('$regno','$pstation','$username','$email','$password')";
        
        if (mysqli_query($con, $sql)){
            $successMsg = '<center>Registration Successfully. <a href="index.php">Click Here to Login</a></center>';
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
                <li class="tab"><a href="#signup">Sign Up</a></li>
            </ul>
            <?php
            if (isset($successMsg)){
                ?>
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-info-sign"></span>
                <?php echo $successMsg; ?>
            </div>
                    <?php
            }
            ?>
            <div class="tab-content">
                <div id="signup">   
                    <h1>Sign Up</h1>
                    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                        <div class="top-row">
                            <div class="field-wrap">
                                <label>
                                    Registration Number<span class="req">*</span>
                                </label>
                                <input type="text" required autocomplete="off" name='regno' />
                                <span class="text-danger"><?php if (isset($errRegno)) echo $errRegno; ?></span>
                            </div>

                            <div class="field-wrap">
                                <label>
                                    Police Station<span class="req">*</span>
                                </label>
                                <input type="text"required autocomplete="off" name='pstation' />
                                <span class="text-danger"><?php if (isset($errPstation)) echo $errPstation; ?></span>
                            </div>
                        </div>

                        <div class="field-wrap">
                            <label>
                                UserName<span class="req">*</span>
                            </label>
                            <input type="text"required autocomplete="off" name='username' />
                            <span class="text-danger"><?php if (isset($errUsername)) echo $errUsername; ?></span>
                        </div>

                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email"required autocomplete="off" name='email' />
                            <span class="text-danger"><?php if (isset($errEmail)) echo $errEmail; ?></span>
                        </div>

                        <div class="field-wrap">
                            <label>
                                Set A Password<span class="req">*</span>
                            </label>
                            <input type="password"required autocomplete="off" name='password'/>
                            <span class="text-danger"><?php if (isset($errPassword)) echo $errPassword; ?></span>
                        </div>

                        <input type="submit" class="button button-block" name="register" />

                    </form>

                </div>
            </div>
        </div>
        <script src='js/jquery.min.js'></script>

        <script src="js/index.js"></script>
    </body>
</html>