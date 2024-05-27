<?php
require_once "config.php";
require_once "session.php";
//require 'create_assessment_function.php';
$error = '';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
    header("location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] == 'on';

    /*$recaptcha_secret = '6LcGCNkpAAAAAD3ebp7I_lvo6VFFyIZ1XHKSnJba';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = array(
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    );

    $recaptcha_options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptcha_data)
        )
    );

    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_json = json_decode($recaptcha_result);

    if ($_POST['g-recaptcha-response']) {
        // Proceed with CAPTCHA assessment
        create_assessment(
            '6LdQmdkpAAAAAD1VIdEtORIxojqQEuE57K9LXb1O', // Replace with your reCAPTCHA site key
            $_POST['g-recaptcha-response'], // Token obtained from the client-side
            'ProiectWeb', // Replace with your Google Cloud Project ID
            'login' // Action name corresponding to CAPTCHA verification
        );
    }

    if (!$recaptcha_json->success) {
        $error .= '<p class="error">CAPTCHA verification failed. Please try again.</p>';
    } else {*/

        if (empty($email)) {
            $error .= '<p class="error">Please enter email.</p>';
        }

        if (empty($password)) {
            $error .= '<p class="error">Please enter your password.</p>';
        }

        if (empty($error)) {
            if ($query = $db->prepare("SELECT id, is_admin, name, password FROM user_table WHERE mail = ?")) {
                $query->bind_param('s', $email);
                $query->execute();
                $result = $query->get_result();
                if ($row = $result->fetch_assoc()) {
                    if (password_verify($password, $row['password'])) {
                        $_SESSION["id"] = $row['id'];
                        $_SESSION["name"] = $row['name'];
                        $_SESSION['logged_in'] = true;
                        $_SESSION['is_admin'] = $row['is_admin'];

                        if ($remember_me) {
                            $expire = time() + (30 * 24 * 3600); // 30 days expiry
                            setcookie('remember_me', $email, $expire, '/');
                        } else {
                            setcookie('remember_me', '', time() - 3600, '/');
                        }
                        header("location: index.php");
                        exit;
                    } else {
                        $error .= '<p class="error">The password is not valid.</p>';
                    }
                } else {
                    $error .= '<p class="error">No User exists with that email address.</p>';
                }
            } else {
                $error .= '<p class="error">Database error. Please try again later.</p>';
            }
            $query->close();
        }
}
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!--<script src="https://www.google.com/recaptcha/enterprise.js?render=6LdQmdkpAAAAAD1VIdEtORIxojqQEuE57K9LXb1O"></script>
    <script>
  function onClick(e) {
    e.preventDefault();
    grecaptcha.enterprise.ready(async () => {
      const token = await grecaptcha.enterprise.execute('6LdQmdkpAAAAAD1VIdEtORIxojqQEuE57K9LXb1O', {action: 'LOGIN'});
    });
  }
    </script>-->
    <script>
        function cap(){
            var alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V'
                    ,'W','X','Y','Z','1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f','g','h','i',
                    'j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', '!','@','#','$','%','^','&','*','+'];
                    var a = alpha[Math.floor(Math.random()*71)];
                    var b = alpha[Math.floor(Math.random()*71)];
                    var c = alpha[Math.floor(Math.random()*71)];
                    var d = alpha[Math.floor(Math.random()*71)];
                    var e = alpha[Math.floor(Math.random()*71)];
                    var f = alpha[Math.floor(Math.random()*71)];

                    var final = a+b+c+d+e+f;
                    document.getElementById("capt").value=final;
                }
               function validcap(){
                    var stg1 = document.getElementById('capt').value;
                    var stg2 = document.getElementById('textinput').value;
                    if(stg1==stg2){
                        return true;
                    } else {
                        alert("Please enter a valid captcha");
                        return false;
                    }
               }
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Login</h2>
                <p>Please fill in your email and password.</p>
                <?php echo $error; ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember_me">
                        <label>Remember Me</label>
                    </div>
                    <!--<div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LdQmdkpAAAAAD1VIdEtORIxojqQEuE57K9LXb1O" data-callback='onSubmit' data-action="LOGIN"></div>
                    </div>-->
                    <label>Enter Captcha:</label>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" readonly id="capt">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="textinput">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" onclick="return validcap()" class="btn btn-lg btn-success btn-block" value="Submit">
                            <!--<button type="submit" onclick="return validcap()" class="btn btn-lg btn-success btn-block">Submit</button>-->
                        </div>
                        <h6>Captcha not visible? <img src="assets/refresh.jpg" width="40px" onclick="cap()"></h6>
                    <p>Don't have an account? <a href="register.php">Register here!</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>