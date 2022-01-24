<div id="timeline">
                    <div id="userbox-clone">
                    <?php if($is_logged_in): ?>
                        <img src=<?php echo '"'.(($current_user["avatar"]==null)?"users/avatars/default.jpg":$current_user["avatar"]).'"'; ?> class="useravatar">
                        <span class="username"><?php echo $current_user["name"] . " " . $current_user["surname"]; ?></span>
                        <span class="usertag">@<?php echo $current_user["nick"]; ?></span>
                        <?php //require("modules/editor.php"); ?>
                    <?php endif; ?>
                    </div>
                    <div id="timelinecontent">
                    <?php
                    if($is_logged_in && isset($_GET["viewlikes"]))
                    {
                        echo '<input type="hidden" id="scroll-mode" value="0">';
                        echo $qlib->getUserTimeline(0, 10, $is_logged_in, true, null, true);
                    }else if($is_logged_in && !isset($_GET["viewall"]))
                    {
                        echo '<input type="hidden" id="scroll-mode" value="1">';
                        echo $qlib->getUserTimeline(0, 10, $is_logged_in);
                    }else if($is_logged_in && isset($_GET["viewall"]))
                    {
                        echo '<input type="hidden" id="scroll-mode" value="2">';
                        echo $qlib->genericTimeline(0, 10, $is_logged_in);
                    }else if(!$is_logged_in)
                    {
                        echo '<input type="hidden" id="scroll-mode" value="3">';
                        echo $qlib->genericTimeline(0, 10);
                    }
                    ?>
                    </div>
                </div>