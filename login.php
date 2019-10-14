<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    if (empty($Username) || empty($Password)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("login.php");
    } else {
        $Found_Account = Login_Attempt($Username, $Password);
        $_SESSION["User_Id"] = $Found_Account["id"];
        $_SESSION["Username"] = $Found_Account["username"];
        if ($Found_Account) {
            $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]} !";
            Redirect_to("dashboard.php?Page=1");
        } else {
            $_SESSION["ErrorMessage"] = "Username / Password salah, coba lagi !";
            Redirect_to("login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/adminstyles.css?v=<?php echo time(); ?>" />

    <!-- <script src="js/jQuery3.4.1.js"></script> -->

    <!-- <script src="js/bootstrap.min.js"></script> -->

    <title>Manage Admin</title>

    <style>
        body {
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div id="head-background1">
    </div>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="blog.php" class="navbar-brand">
                    <img id="logo" src="images/smkn8bone_logo.png">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">SMKN 8 BONE</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="head-background2">
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <div style="padding-top: 20vh;">
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                    <h2>Welcome Back !</h2>
                </div>
                <div>
                    <form action="login.php" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label for="Username"><span class="Fieldinfo">Username:</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-envelope text-primary"></span>
                                    </span>
                                    <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Password"><span class="Fieldinfo">Password:</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock text-primary"></span>
                                    </span>
                                    <input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
                                </div>
                            </div>
                            <br>
                            <input class="btn btn-info btn-block" type="submit" name="Submit" value="Login">
                        </fieldset>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>