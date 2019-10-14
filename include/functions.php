<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php
function Redirect_to($New_Location)
{
    header("Location:" . $New_Location);
    exit;
}

function Login_Attempt($Username, $Password)
{
    global $Connection;
    $Query = $Connection->query("SELECT * FROM registration WHERE username='$Username' AND password='$Password'");
    if ($admin = mysqli_fetch_assoc($Query)) {
        return $admin;
    } else {
        return null;
    }
}

function Login()
{
    if (isset($_SESSION["User_Id"])) {
        return true;
    }
}

function Confirm_Login()
{
    if (!Login()) {
        $_SESSION["ErrorMessage"] = "Silahkan Login terlebih dahulu !";
        Redirect_to("login.php");
    }
}
?>
