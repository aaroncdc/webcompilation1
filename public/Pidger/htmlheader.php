<header>
<div id="loading-screen">
<h1>¡Paciencia! Estamos preparando la página...</h1>
<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
<span class="sr-only">Loading...</span>
</div>
    <a href="index.php"><img src="static/logopidger.png" class="logohead">
    <span class="title">Pidger</span></a>
<?php if(!$is_logged_in): ?>
    <div class="button button-login" id="button-login">
        <span>Iniciar Sesión</span>
    </div>
    <a href="register.php"><div class="button button-register" id="button-register">
        <span>Registrarse</span>
    </div></a>
    <div class="login-form">
        <form method="post" action="login.php">
        <center><h6>Inicio de sesión</h6></center>
        <table>
            <tr>
                <td><label>E-Mail:</label></td>
                <td><input type="text" name="vCorreo" id="iCorreo"></td>
            </tr>
            <tr>
                <td><label>Contraseña:</label></td>
                <td><input type="password" name="vPassword" id="iPassword"></td>
            </tr>
        </table>
        <input type="submit" value="Iniciar Sesión" class="button">
        </form>
<?php else: ?>
    <div class="user-info-login">
        <img src=<?php echo '"'.(($current_user["avatar"]==null)?"users/avatars/default.jpg":$current_user["avatar"]).'"'; ?> class="user-avatar">
        <a href=<?php echo "\"profile.php?id=".$current_user["id"]."\""; ?> ><span class="user-name-login">@<?php echo $current_user["nick"]; ?></span></a>
        <span class="user-options-login">
            <a href="usersettings.php">Editar perfíl</a>
            <a href="sessionend.php">Cerrar Sesión</a>
            <?php if($current_user["type"] > 0): ?>
                <a href="mod.php" class="mod-link">Moderación</a>
            <?php endif; ?>
        </span>
    </div>
<?php endif; ?>
</header>