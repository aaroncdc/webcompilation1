<?php
require_once("db/connect.php");
require_once("db/session.php");
$is_logged_in = checkSession();

$current_user = null;
$user_privacy = null;
if($is_logged_in)
{
    require_once("db/qlib.php");
    $current_user = $qlib->getUserFromSession($current_session);
    $user_privacy = $qlib->getUserPrivacyOptions($current_user["id"]);
}
?>
<!DOCTYPE html>
<html>
<?php require_once("headerdata.php") ?>

<body>
<?php if(isset($_GET["id"])){
    $profile = $qlib->getUserFromId($_GET["id"]);
?>
<div id="main-container">
<?php include("htmlheader.php") ?>
    <div class="timeline-profile">
    <div id="userbox-profile">

    <?php if($qlib->isFollowing($is_logged_in, $_GET["id"])): ?>
        <span class="unfollow-icon" unfollow=<?php echo '"'.$profile["id"].'"'; ?>><i class="fa fa-user-times fa-lg"></i></span>
    <?php else: ?>
        <span class="follow-icon" follow=<?php echo '"'.$profile["id"].'"'; ?>><i class="fa fa-user-plus fa-lg"></i></span>
    <?php endif; ?>
    <?php if($qlib->isBlocking($is_logged_in, $_GET["id"])): ?>
    <span class="unblock-icon" unblock=<?php echo '"'.$profile["id"].'"'; ?>><i class="fa fa-unlock fa-lg"></i></span>
    <?php else: ?>
    <span class="block-icon" block=<?php echo '"'.$profile["id"].'"'; ?>><i class="fa fa-ban fa-lg"></i></span>
    <?php endif; ?>

            <img src=<?php echo '"'.(($profile["avatar"]==null)?"users/avatars/default.jpg":$profile["avatar"]).'"'; ?> class="useravatar-profile">
            <span class="username-profile"><?php echo $profile["name"] . " " . $profile["surname"]; ?></span>
            <span class="usertag-profile">@<?php echo $profile["nick"]; ?></span>
        </div>
        <div id="timelinecontent">
            <?php echo $qlib->getUserTimeline(0, 20, $_GET["id"], false, ($is_logged_in)?$is_logged_in:null); ?>
        </div>
    </div>
</div>
<input type="hidden" value=<?php echo '"'.$is_logged_in.'"' ?> id="sid">
<?php } ?>
<script src="js/main.js"></script>
<script src="js/profile.js"></script>
</body>
</html>
<?php
    $qlib->closeall();
    mysqli_close($con);
?>