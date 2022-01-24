<?php if(!$is_logged_in): ?>

<div id="settings-pane">
    <div id="settings-breadcumb">ERROR: No tienes ninguna sesión iniciada.</div>
</div>

<?php else: ?>
<script src="js/settings.js"></script>
<div id="settings-pane">
    <div id="settings-breadcumb"></div>
    <div id="settings-stuff">
        <div id="config-section-1" class="config-section">
        <h3 class="title-panel">Modificar datos de usuario</h3>
            <table>
                <tr>
                    <td><label>Nombre de usuario:</label></td>
                    <td><span class="toggle-field" id="toggle-field-1"><?php echo $current_user["nick"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-1"></i>
                    <div class="field-option" id="field-1" field="nick" table="userdata"><input type="text" value=<?php echo '"'.$current_user["nick"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div>
                </td>
                </tr>
                <tr>
                    <td><label>Nombre:</label></td>
                    <td><span class="toggle-field" id="toggle-field-2"><?php echo $current_user["name"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-2"></i>
                    <div class="field-option" id="field-2" field="name" table="userdata"><input type="text" value=<?php echo '"'.$current_user["name"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                </tr>
                <tr>
                    <td><label>Apellidos:</label></td>
                    <td><span class="toggle-field" id="toggle-field-3"><?php echo $current_user["surname"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-3"></i>
                    <div class="field-option" id="field-3" field="surname" table="userdata"><input type="text" value=<?php echo '"'.$current_user["surname"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                </tr>
                <tr>
                    <td><label>Fecha de nacimiento:</label></td>
                    <td><span class="toggle-field" id="toggle-field-4"><?php echo $current_user["birthdate"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-4"></i>
                    <div class="field-option" id="field-4" field="birthdate" table="userdata"><input type="date" value=<?php echo '"'.$current_user["birthdate"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                </tr>
                <tr>
                    <td><label>Sexo:</label></td>
                    <td><span class="toggle-field" id="toggle-field-5"><?php echo $current_user["gender"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-5"></i>
                    <div class="field-option" id="field-5" field="gender" table="userdata"><input type="text" value=<?php echo '"'.$current_user["gender"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                </tr>
                <tr>
                    <td><label>Dirección:</label></td>
                    <td><span class="toggle-field" id="toggle-field-6"><?php echo $current_user["adress"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-6"></i>
                    <div class="field-option" id="field-6" field="adress" table="userdata"><input type="text" value=<?php echo '"'.$current_user["adress"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                </tr>
                <tr>
                    <td><label>Nacionalidad:</label></td>
                    <td><span class="toggle-field" id="toggle-field-7"><?php echo $current_user["nationality"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-7"></i>
                    <div class="field-option" id="field-7" field="nationality" table="userdata"><input type="text" value=<?php echo '"'.$current_user["nationality"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                </tr>
                <tr>
                    <td><label>Teléfono:</label></td>
                    <td><span class="toggle-field" id="toggle-field-8"><?php echo $current_user["phone"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-8"></i>
                    <div class="field-option" id="field-8" field="phone" table="userdata"><input type="text" value=<?php echo '"'.$current_user["phone"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                </tr>
            </table>
            <h3 class="title-panel">Modificar Correo</h3>
                <table>
                    <tr>
                        <td><label>Cambiar correo:</label></td>
                        <td><span class="toggle-field" id="toggle-field-9"><?php echo $current_user["mail"]; ?></span> <i class="fa fa-pencil fa-fw edit-button" aria-hidden="true" togglefield="field-9"></i>
                        <div class="field-option" id="field-9" field="mail" table="userdata"><input type="text" value=<?php echo '"'.$current_user["mail"] .'"'; ?> class="option-text"><button class="option-button">Cambiar</button></div></td>
                    </tr>
                </table>
            <h3 class="title-panel">Modificar Contraseña</h3>
            <form method="POST" action="changepass.php">
            <input type="hidden" id="usses2" name="usid" value=<?php echo '"'.$is_logged_in.'"'?>>
                <table>
                    <tr>
                        <td><label>Constraseña actual: </label></td>
                        <td><input type="password" id="current-password" name="cpass"></td>
                    </tr>
                    <tr>
                        <td><label>Nueva contraseña: </label></td>
                        <td><input type="password" id="user-password-1" name="npass1"></td>
                    </tr>
                    <tr>
                        <td><label>Repita la contraseña: </label></td>
                        <td><input type="password" id="user-password-2" name="npass2"></td>
                    </tr>
                    <tr>
                    <td></td>
                    <td><input type="submit" value="Cambiar"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="config-section-2" class="config-section">
        <h3 class="title-panel">Cambiar imágen de usuario</h3>
            <img src=<?php echo '"'.(($current_user["avatar"]==null)?"users/avatars/default.jpg":$current_user["avatar"]).'"'; ?> class="option-avatar-preview">
            <label>Selecciona una imágen de perfíl: </label><input type="file" id="load-profile-field"><button id="load-profile-image">Cargar</button>
            
            <div class="profile-drop-zone" id="profile-image-drop" ondrop="drop_handler(event);" ondragover="dragover_handler(event);" ondragend="dragend_handler(event);">
                <div class="profile-drop-zone-border"><strong>O mueve un archivo de imágen a ésta zona</strong></div>
            </div>

        </div>
        <div id="config-section-3" class="config-section">
        <h3 class="title-panel">Opciones de privacidad</h3>
        <table>
            <legend class="options-legend">Nombre</legend>
            <tr>
                <td><label>Mostrar nombre al público:</label><input type="radio" name="name-visibility" value="2" <?php if($user_privacy["showname"] >= 2){ echo "checked"; }?>></td>
                <td><span class="options-description">Se mostrará el nombre al resto de usuarios.</span></td>
            </tr>
            <tr>
                <td><label>Mostrar nombre solo a amigos:</label><input type="radio" name="name-visibility" value="1" <?php if($user_privacy["showname"] == 1){ echo "checked"; }?>></td>
                <td><span class="options-description">Se mostrará el nombre sólo a los miembros de tu lista de amigos.</span></td>
            </tr>
            <tr>
                <td><label>No mostrar nombre:</label><input type="radio" name="name-visibility" value="0" <?php if($user_privacy["showname"] <= 0){ echo "checked"; }?>></td>
                <td><span class="options-description">Tu nombre no estará visible para nadie.</span></td>
            </tr>
        </table>
        <table>
            <legend class="options-legend">Correo</legend>
            <tr>
                <td><label>Permitir encontrarte por tu correo:</label><input type="checkbox" name="mail-search" id="mail-search" <?php if($user_privacy["publicmail"] > 0){ echo "checked"; }?>></td>
                <td><span class="options-description">Los usuarios te podrán buscar por tu correo electrónico.</span></td>
            </tr>
        </table>
        <table>
            <legend class="options-legend">Newsletter</legend>
            <tr>
                <td><label for="accept-news">Deseo recibir las newsletter: </label><input type="checkbox" name="accept-news" id="accept-news" <?php if($current_user["news"]){ echo "checked"; }?>></td>
                <td><span class="options-description">Recibirás periodicamente correo con información sobre Pidger.</span></td>
            </tr>
        </table>
        </div>
        <div id="config-section-4" class="config-section">
        <h3 class="title-panel">Gente a la que sigues</h3>
            <div class="follower-list">
                <div class="scrollhide">
                    <?php
                        $follows = $qlib->getFollowingUsers($current_user["id"]);
                        if($follows)
                            foreach($follows as $following)
                            {
                                echo '<div class="follower-info" val="'.$following["link"].'">';
                                echo '<img src="'.(($following["avatar"])?$following["avatar"]:"users/avatars/default.jpg").'" class="follower-avatar">';
                                echo '<span class="follower-name">@'.$following["nick"].'</span>';
                                echo '<a href="profile.php?id='.$following["id"].'" class="follower-profile-link">Ver perfíl</a>';
                                echo '<i class="fa fa-window-close profile-unfollow"></i>';
                                echo '</div>';
                            }
                    ?>
                </div>
            </div>
        </div>
        <div id="config-section-5" class="config-section">
        <h3 class="title-panel">Configuración de usuarios bloqueados</h3>
        <div class="blocking-list">
                <div class="scrollhide">
                    <?php
                        $follows = $qlib->getBlockingUsers($current_user["id"]);
                        if($follows)
                            foreach($follows as $following)
                            {
                                echo '<div class="blocking-info" val="'.$following["link"].'">';
                                echo '<img src="'.(($following["avatar"])?$following["avatar"]:"users/avatars/default.jpg").'" class="follower-avatar">';
                                echo '<span class="follower-name">@'.$following["nick"].'</span>';
                                echo '<a href="profile.php?id='.$following["id"].'" class="follower-profile-link">Ver perfíl</a>';
                                echo '<i class="fa fa-window-close profile-unblock"></i>';
                                echo '</div>';
                            }
                    ?>
                </div>
            </div>
        </div>
        <div id="config-section-6" class="config-section">
        <h3 class="title-panel">Borrar cuenta de usuario</h3>
        <?php
            if(!$current_user["deleted"]):
        ?>
        <span class="config-warning">El borrado de cuenta marcará tu cuenta para borrar. La cuenta permanecerá en éste estado por 7 dias. Durante éste periodo, puedes acceder a tu cuenta
            y ver tus datos. Otros usuarios no podrán ver tu cuenta mientras se encuentre marcada para borrar. Pasados 7 dias, la cuenta será borrada definitivamente, y con ello
            todos tus datos (no quedará nada). Puedes cancelar éste proceso en cualquier momento, dentro del margen de 7 dias.
        </span>
            <form method="POST" action="deleteaccount.php">
            <div class="options-frame"><input type="checkbox" name="option-set-deletion"><label>Estoy seguro de que quiero borrar mi cuenta.</label></div>
            <input type="hidden" id="usses1" name="usid" value=<?php echo '"'.$is_logged_in.'"'?>>
            <input type="submit" value="Borrar mi cuenta">
            </form>
            <?php
                else:
            ?>
            <span class="config-warning">Su cuenta está marcada para ser borrada el <?php setlocale(LC_ALL,"es_ES"); echo strftime("%A %d de %B del %Y, a las %T horas", strtotime($current_user["expire"])); ?>.
            </span>
            <form method="POST" action="undeleteaccount.php">
                <input type="hidden" id="usses1" name="usid" value=<?php echo '"'.$is_logged_in.'"'?>>
                <input type="submit" value="Anular borrado">  
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
