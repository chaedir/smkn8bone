<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_GET["delete"])) {
    $IdFromURL = $_GET["delete"];
    $Query = mysqli_query($Connection, "DELETE FROM slideshow WHERE id='" . $IdFromURL . "'");
    if ($Query) {
        $_SESSION["SuccessMessage"] = "Comment Deleted Successfully";
        Redirect_to("dashBeranda.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
        Redirect_to("dashBeranda.php");
    }
}
?>