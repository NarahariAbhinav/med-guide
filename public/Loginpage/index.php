<?php
require_once "config.php";

if (isset($_GET["code"])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();
        $_SESSION['user_email_address'] = $data['email'];
        $_SESSION['user_first_name'] = $data['given_name'];
        $_SESSION['user_last_name'] = $data['family_name'];
        $_SESSION['user_image'] = $data['picture'];
        $_SESSION['login_button'] = false;

        // Redirect to the user dashboard after successful login
        header('Location: Homepage/home.html');
        exit();

    }
}

if (isset($_SESSION['login_button'])) {
    $login_button = $_SESSION['login_button'];
} else {
    $login_button = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Login Page</title>
    <style>
        .google-signin-button {
            display: inline-block;
            background: #4285f4;
            color: white;
            border-radius: 4px;
            padding: 10px 24px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
            transition: background 0.3s ease;
        }

        .google-signin-button:hover {
            background: #357ae8;
        }

        .google-icon {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="signup.php" method="post">
                <h1>Create Account</h1>
                <br />
                <input type="text" id="name" placeholder="Name" name="name" required>
                <input type="email" id="email" placeholder="Email" name="email" required>
                <input type="password" id="password" placeholder="Password" name="password" required>
                <input type="password" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword" required>
                <button><a href="#">Sign Up</a></button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="signin.php" method="post">
                <h1>Sign In</h1>
                <br />
                <input type="email" placeholder="Email" name="email">
                <input type="password" placeholder="Password" name="password">
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
                <button><a href="#">Sign In</a></button>
                <div class="or-option">or</div>
                <a href="<?= $google_client->createAuthUrl() ?>" class="google-signin-button"><i class="fab fa-google google-icon"></i> Sign in with Google</a>
                <?php
                if ($login_button) {
                    ?>
                    <center></center>
                    <?php
                } else {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Welcome User</div>
                        <div class="panel-body">
                            <img src="<?=$_SESSION['user_image']?>" class="img-responsive img-circle img-thumbnail" />
                            <h3><b>Name :</b><?=$_SESSION['user_first_name']?> <?=$_SESSION['user_last_name']?></h3>
                            <h3><b>Email :</b> <?=$_SESSION['user_email_address']?> </h3>
                            <h3><a href="logout.php">Logout</h3>
                        </div>
                        <div align="center"></div>
                    </div>
                    <?php
                }
                ?>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome !</h1>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome Back!</h1>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="loginjs.js"></script>
    

</body>

</html>
