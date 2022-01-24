<?php if(!$is_logged_in): ?>
<div id="left-pane">
    <div id="userbox">
        <img src="users/avatars/default.jpg" class="useravatar">
        <span class="username"><?php echo $current_user["name"] . " " . $current_user["surname"]; ?></span>
        <span class="usertag">@<?php echo $current_user["nick"]; ?></span>
    </div>
</div>
<?php else: ?>

<div id="left-pane" class="settings">
    <div id="userbox">
        <img src=<?php echo '"'.(($current_user["avatar"]==null)?"users/avatars/default.jpg":$current_user["avatar"]).'"'; ?> class="useravatar">
        <span class="username"><?php echo $current_user["name"]; ?></span>
        <span class="usertag">@<?php echo $current_user["nick"]; ?></span>
        <input type="hidden" id="usid" value=<?php echo '"'.$current_user["id"].'"'?>>
        <input type="hidden" id="usses" value=<?php echo '"'.$is_logged_in.'"'?>>
    </div>
    <div id="trendings">
            <ul class="options-menu">
                <a href="#" panel="1"><li>Administración de usuarios</li></a>
                <a href="#" panel="2"><li>Mensajes reportados</li></a>
                <a href="#" panel="3"><li>Baneos</li></a>
                <!--<a href="#" panel="4"><li>Seguidores</li></a>
                <a href="#" panel="5"><li>Usuarios Bloqueados</li></a>
                <a href="#" panel="6"><li>Borrar cuenta</li></a>-->
            </ul>
    </div>
</div>
<?php endif; ?>