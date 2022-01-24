<div id="left-pane">
    <div id="userbox">
    <?php if($is_logged_in): ?>
        <img src=<?php echo '"'.(($current_user["avatar"]==null)?"users/avatars/default.jpg":$current_user["avatar"]).'"'; ?> class="useravatar">
        <span class="username"><?php echo $current_user["name"]; ?> </span>
        <span class="usertag">@<?php echo $current_user["nick"]; ?></span>
        <?php require("modules/editor.php"); ?>
    <?php else: ?>
    <span class="register-please"><a href="register.php">¡Registrate grátis!</a></span>
    <p class="text">Registrate para poder mandar mensajes y seguir a tus usuarios favoritos. ¡Es grátis! Y no tardas ni un minuto.</p>
    <!--<a href="register.php" class="register-link">Haga click aquí</a>-->
    <?php endif; ?>
                        
    </div>
    <div id="trendings">
        <!-- Hot topics -->
        <span class="panel-header">Hot Topics</span>
        <ul class="hottopiclist">
        <?php
            require_once("db/qlib.php");
            echo $qlib->getHotTopics();
        ?>
        </ul>
    </div>
</div>