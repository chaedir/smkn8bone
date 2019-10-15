<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_GET["id"])) {
    $IdFromURL = $_GET["id"];
    $Admin = $_SESSION["Username"];
    $Query = mysqli_query($Connection, "UPDATE comments SET status='" . ON . "', approvedby='" . $Admin . "' WHERE id='" . $IdFromURL . "'");
    if ($Query) {
        $_SESSION["SuccessMessage"] = "Comment Approved Successfully";
        Redirect_to("comments.php?Page=1");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
        Redirect_to("comments.php?Page=1");
    }
}
?>