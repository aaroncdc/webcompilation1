<?php
    setlocale(LC_ALL, 'es_ES');
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
    <?php require_once("headerdata.php"); ?>
<body>
<div id="main-container">
    <?php require_once("htmlheader.php"); ?>
    <?php if($current_user["type"]>0): ?>    
        <?php require_once("panels/mod-content.php"); ?>
    <?php else: ?>
    <div id="settings-pane">
        <div id="settings-breadcumb">ERROR: No tienes permisos para acceder a ésta página.</div>
    </div>
    <?php endif; ?>
</div>
<script src="js/main.js"></script>
</body>
</html>