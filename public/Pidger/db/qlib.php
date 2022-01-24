<?php

/*
   ____                          _      _ _                          
  / __ \                        | |    (_) |                         
 | |  | |_   _  ___ _ __ _   _  | |     _| |__  _ __ __ _ _ __ _   _ 
 | |  | | | | |/ _ \ '__| | | | | |    | | '_ \| '__/ _` | '__| | | |
 | |__| | |_| |  __/ |  | |_| | | |____| | |_) | | | (_| | |  | |_| |
  \___\_\\__,_|\___|_|   \__, | |______|_|_.__/|_|  \__,_|_|   \__, |
                          __/ |                                 __/ |
                         |___/                                 |___/ 

    Librería de consultas a BBDD para el proyecto PIDGER.
    Por AC. de C. - 30/01/2018
    Versión 0.8.2
--------------------------------------------------------------------------
-   GUÍA DE USO                                                          -
--------------------------------------------------------------------------
1. Importar db/connect.php
2. Importar db/qlib.php
3. Llamar a las funciones usando $qlib->funcion(). El objeto $qlib se crea
automáticamente al importar qlib.

- VARIABLES
$query_lib: Array asociativo con las consultas ya preparadas [nombre => consulta].
*/

if(!isset($con))
    die("Error: qlib se ha importado antes que connect");

    $query_lib = ["reg_new_user" => $con->prepare("INSERT INTO  userdata (nick,name,surname,password,birthdate,gender,adress,phone,nationality,mail,eula,news,cookies,privacy,avatar,type) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"),
"login_user" => $con->prepare("SELECT * FROM userdata WHERE mail=? AND password=?"),
"make_session" => $con->prepare("INSERT INTO sessions (userid, session_key, login_expire, browser_agent, client_ip) VALUES (?,?,?,?,?)"),
"get_user_from_session" => $con->prepare("SELECT userid FROM sessions WHERE session_key = ?"),
"get_user_from_id" => $con->prepare("SELECT * FROM userdata WHERE id = ?"),
"post-message" => $con->prepare("INSERT INTO messages (author, content, medialist, deleted, shared, replyto, tags) VALUES (?,?,?,?,?,?,?)"),
"get-timeline" => $con->prepare("SELECT * FROM messages ORDER BY postdate DESC LIMIT ?, ?"),
"register_tag" => $con->prepare("INSERT INTO tags (name,mentions) VALUES (?,1)"),
"get_tag" => $con->prepare("SELECT * FROM tags WHERE name = ?"),
"increase_tag_count" => $con->prepare("UPDATE tags SET mentions = mentions + 1 WHERE name = ?"),
"get_hot_topics" => $con->prepare("SELECT * FROM tags ORDER BY mentions DESC LIMIT 0,10"),
"bind_tag" => $con->prepare("INSERT INTO messagetags (message,tag) VALUES (?, ?)"),
"likemessage" => $con->prepare("INSERT INTO likedcontent (likedmsg, user) VALUES (?,?)"),
"getpostlikes" => $con->prepare("SELECT likes FROM messages WHERE id = ?"),
"updatepostlikes" => $con->prepare("UPDATE messages SET likes = likes + 1 WHERE id = ?"),
"checkliked" => $con->prepare("SELECT * FROM likedcontent WHERE likedmsg = ?"),
"setavatar" => $con->prepare("UPDATE userdata SET avatar = ? WHERE id = ?"),
"getavatar" => $con->prepare("SELECT avatar FROM userdata WHERE id = ?"),
"endsession" => $con->prepare("DELETE FROM sessions WHERE session_key = ?"),
"get_user_timeline" => $con->prepare("SELECT * FROM messages WHERE author = ? ORDER BY postdate DESC LIMIT ?, ?"),
"session_user" => $con->prepare("SELECT userdata.* FROM sessions INNER JOIN userdata ON sessions.userid = userdata.id WHERE sessions.session_key = ?"),
"follow_user" => $con->prepare("INSERT INTO follows (follower, following) VALUES (?,?)"),
"unfollow_user" => $con->prepare("DELETE FROM follows WHERE follower = ? AND following = ?"),
"check_follow" => $con->prepare("SELECT * FROM follows WHERE follower = ? AND following = ?"),
"get_user_followers" => $con->prepare("SELECT * from follows WHERE follower = ?"),
"register_media" => $con->prepare("INSERT INTO media (message,type,url,width,height,size,length) VALUES (?,?,?,?,?,?,?)"),
"update_media" => $con->prepare("UPDATE media SET message = ?, url = ? WHERE id = ?"),
"get_media" => $con->prepare("SELECT * FROM media WHERE id = ?"),
"get_message_media" => $con->prepare("SELECT * FROM media WHERE message = ?"),
"repost" => $con->prepare("INSERT INTO messages (author, content, medialist, deleted, shared, replyto, tags) VALUES (?,\"\",NULL,0,?,NULL,NULL)"),
"get_message" => $con->prepare("SELECT * FROM messages WHERE id = ?"),
"create_user_privacy" => $con->prepare("INSERT INTO userprivacy (user) VALUES (?)"),
"report_error" => $con->prepare("INSERT INTO bug_reporting (error_number, error_description, function, backtrace) VALUES (?,?,?,?)"),
"remove_media" => $con->prepare("DELETE FROM media WHERE id = ?"),
"get_user_privacy" => $con->prepare("SELECT * FROM userprivacy WHERE id = ?"),
"get_following_users" => $con->prepare("SELECT follows.following AS link, userdata.* FROM follows INNER JOIN userdata ON follows.following = userdata.id WHERE follows.follower = ?"),
"block_user" => $con->prepare("INSERT INTO blocks (userA, userB) VALUES (?,?)"),
"check_block" => $con->prepare("SELECT * FROM blocks WHERE userA = ? AND userB = ?"),
"unblock_user" => $con->prepare("DELETE FROM blocks WHERE userA = ? AND userB = ?"),
"get_blocking_users" => $con->prepare("SELECT blocks.userB AS link, userdata.* FROM blocks INNER JOIN userdata ON blocks.userB = userdata.id WHERE blocks.userA = ?"),
"mark_user_deletion" => $con->prepare("UPDATE userdata SET expire = ?, deleted = 1 WHERE id = ?"),
"unmark_user_deletion" => $con->prepare("UPDATE userdata SET expire = NULL, deleted = 0 WHERE id = ?"),
"update_password" => $con->prepare("UPDATE userdata SET password = ? WHERE id = ?"),
"search_user" => $con->prepare("SELECT * FROM userdata WHERE nick LIKE ? OR name LIKE ? OR surname LIKE ? OR phone = ? OR mail LIKE ?"),
"ban_user" => $con->prepare("UPDATE userdata SET banned = 1, expire = ?, reason = ? WHERE id = ?"),
"unban_user" => $con->prepare("UPDATE userdata SET banned = 0, expire = null, reason = null WHERE id = ?"),
"get_banned_users" => $con->prepare("SELECT * FROM userdata WHERE banned > 0 ORDER BY expire ASC"),
"report_message" => $con->prepare("INSERT INTO reportedmessages (message,user,reason) VALUES (?,?,?)"),
"get_reported_messages" => $con->prepare("SELECT * FROM reportedmessages ORDER BY id DESC LIMIT 0,20"),
"remove_reported_message" => $con->prepare("DELETE FROM reportedmessages WHERE message = ?"),
"delete_message" => $con->prepare("DELETE FROM messages WHERE id = ?")];

//die("Whoops! Hay un error (".$con->errno."): " . $con->error);
$con->query("SET GLOBAL sql_mode=''");
class qlib {
    public $error = [];
    public $is_error = false;

    function raise_error($code, $description, $function = "Unknown")
    {
        global $query_lib;
        global $con;

        echo '<div class="dreaded">';
        echo '<img src="static/error.webp" class="errorimage">';
        echo "<br><br>Whoops! Hay un error 💩💩💩 (".$code."): " . $description . "<br> <font color=\"RED\">## STOP:</font> " . $function . "<br><br><font color=\"RED\">## BACKTRACE:</font> ";
        debug_print_backtrace();
        $this->error = ["code"=>$code, "description"=>$description];
        $this->is_error = true;
        $stacktraceinfo = json_encode(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT));

        $query_lib["report_error"]->bind_param("isss",intval($code),$description,$function,$stacktraceinfo);
        $query_lib["report_error"]->execute();
        if($query_lib["report_error"]->errno != 0 || $query_lib["report_error"]->affected_rows < 1)
        {
            echo "<p>Además se ha producido otro error al intentar reportar el primero.</p>";
            echo "<font color=\"red\">(" . $query_lib["report_error"]->errno . "): " . $query_lib["report_error"]->error . "</font>";
        }else{
            echo "<p>Hemos reportado éste error a nuestros gatitos programadores.</p>";
        }
        echo '</div>';
        return;
    }

    function lower_error()
    {
        $error = [];
        $is_error = false;
        return;
    }

    function deleteReportedMessage($id)
    {
        global $query_lib;
        global $con;

        $query_lib["delete_message"]->bind_param("i", $id);
        $query_lib["delete_message"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"ignoreReport");
            return null;
        }
        if($query_lib["delete_message"]->affected_rows < 1)
        {
            $query_lib["delete_message"]->free_result();
            return false;
        }
        $query_lib["delete_message"]->free_result();

        $query_lib["remove_reported_message"]->bind_param("i", $id);
        $query_lib["remove_reported_message"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"ignoreReport");
            return null;
        }
        if($query_lib["remove_reported_message"]->affected_rows < 1)
        {
            $query_lib["remove_reported_message"]->free_result();
            return false;
        }
        $query_lib["remove_reported_message"]->free_result();
        $this->lower_error();
        return true;
    }

    function ignoreReport($id)
    {
        global $query_lib;
        global $con;

        $query_lib["remove_reported_message"]->bind_param("i", $id);
        $query_lib["remove_reported_message"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"ignoreReport");
            return null;
        }
        if($query_lib["remove_reported_message"]->affected_rows < 1)
        {
            $query_lib["remove_reported_message"]->free_result();
            return false;
        }
        $query_lib["remove_reported_message"]->free_result();
        $this->lower_error();
        return true;
        
    }

    function getReported()
    {
        global $query_lib;
        global $con;

        $query_lib["get_reported_messages"]->execute();
        $res = $query_lib["get_reported_messages"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"report");
            return null;
        }
        if($res->num_rows < 0)
            return "";
        $html = "";
        while($row = $res->fetch_assoc())
        {

            $rmes = $this->getMessage($row["message"]);
            $muser = $this->getUserFromId($rmes["author"]);
            $ruser = $this->getUserFromId($row["user"]);
            $html .= '<div class="reported-message" msgid="'.$row["message"].'" usid="'.$muser["id"].'">';
            $html .= '<strong>Reportado por: <a href="profile.php?id='.$ruser["id"].'">@'.$ruser["nick"].'</a></strong><br>';
            $html .= '<strong>Creado por: <a href="profile.php?id='.$muser["id"].'">@'.$muser["nick"].'</a></strong><br>';
            $html .= '<strong>Contenido:</strong><br>';
            $html .= '<p class="message-content">'.$rmes["content"].'</p>';
            
            $media = explode(",",$rmes["medialist"]);
            if($media[0] != "")
            {
                $html .= '<div class="message-media">';
                foreach($media as $item)
                {
                    $img = $this->getMedia(intval($item));
                    $html .= '<img src="'.$img["url"].'" class="media-small" />';
                }
                $html .= '</div>';
            }
            $html .= '<i class="fa fa-thumbs-up ignore-message"></i><span>Ignorar</span>';
            $html .= '<i class="fa fa-times delete-message"></i><span>Borrar</span>';
            $html .= '<i class="fa fa-user-times ban-user"></i><span>Banear usuario</span>';
            $html .= '</div>';
        }
        $query_lib["get_reported_messages"]->free_result();
        return $html;
    }

    function report($mid, $user, $reason)
    {
        global $query_lib;
        global $con;

        $query_lib["report_message"]->bind_param("iis", $mid, $user, $reason);
        $query_lib["report_message"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"report");
            return null;
        }
        if($query_lib["report_message"]->affected_rows < 1)
        {
            $query_lib["report_message"]->free_result();
            return false;
        }
        $this->lower_error();
        return true;
    }

    function unban($id)
    {
        global $query_lib;
        global $con;

        $query_lib["unban_user"]->bind_param("i", $id);
        $query_lib["unban_user"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"unban");
            return null;
        }
        if($query_lib["unban_user"]->affected_rows < 1)
        {
            $query_lib["unban_user"]->free_result();
            return false;
        }
        $this->lower_error();
        return "Usuario desbaneado: " . $id;
    }

    function getBannedUsers()
    {
        global $query_lib;
        global $con;

        $query_lib["get_banned_users"]->execute();
        $res = $query_lib["get_banned_users"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getBannedUsers");
            return null;
        }
        if($res->num_rows < 1)
        {
            $query_lib["get_banned_users"]->free_result();
            return false;
        }
        $results = [];
        while($row = $res->fetch_assoc())
        {
            $item = '<div class="banned-info">';
            $item .= '<img src="'.(($row["avatar"])?$row["avatar"]:"users/avatars/default.jpg").'" class="follower-avatar">';
            $item .= '<span class="follower-name">@'.$row["nick"].'</span>';
            $item .= '<a href="profile.php?id='.$row["id"].'" class="follower-profile-link">Ver perfíl</a>';
            $item .= '<span class="ban-data"><strong>Hasta el: </strong>'.$row["expire"].'</span>';
            $item .= '<span class="ban-data"><strong>Razón: </strong>'.$row["reason"].'</span>';
            $item .= '<i class="fa fa-ban mod-user-unban" user="'.$row["id"].'"></i>';
            $item .= '</div>';
            array_push($results, $item);
        }
        $this->lower_error();
        $query_lib["search_user"]->free_result();
        return $results;
    }

    function banhammer($id, $expire, $reason)
    {
        global $query_lib;
        global $con;

        $query_lib["ban_user"]->bind_param("ssi", $expire, $reason, $id);
        $query_lib["ban_user"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"banhammer");
            return null;
        }
        if($query_lib["ban_user"]->affected_rows < 1)
        {
            $query_lib["ban_user"]->free_result();
            return false;
        }
        $this->lower_error();
        return "Usuario baneado: " . $id . " hasta el " . $expire . " por el motivo: " . $reason;
    }

    function searchUser($search)
    {
        global $query_lib;
        global $con;
        $search = "%" . $search . "%";
        $query_lib["search_user"]->bind_param("sssss",$search,$search,$search,$search,$search);
        $query_lib["search_user"]->execute();
        $res = $query_lib["search_user"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"searchUser");
            return null;
        }
        if($res->num_rows < 1)
        {
            $query_lib["search_user"]->free_result();
            return false;
        }
        $results = [];
        while($row = $res->fetch_assoc())
        {
            $item = '<div class="blocking-info">';
            $item .= '<img src="'.(($row["avatar"])?$row["avatar"]:"users/avatars/default.jpg").'" class="follower-avatar">';
            $item .= '<span class="follower-name">@'.$row["nick"].'</span>';
            $item .= '<a href="profile.php?id='.$row["id"].'" class="follower-profile-link">Ver perfíl</a>';
            if($row["banned"] < 1)
                $item .= '<i class="fa fa-ban mod-user-ban" user="'.$row["id"].'"></i>';
            else
                $item .= '<i class="fa fa-ban mod-user-unban" user="'.$row["id"].'"></i>';
            $item .= '<div class="mod-ban-options" user="'.$row["id"].'">
            <table>
            <tr>
                <td><label>Expiration date:</label></td><td><input type="date" name="ban-expire" value="'.date("Y-m-d").'"></td>
            </tr><tr>
            <td><label>Reason:</label></td><td><input type="text" name="ban-reason"></td>
            </tr><tr><td colspan="2"><button class="dotheban">Ban</button></td>
            </tr>
            </table>
            </div>';
            $item .= '</div>';
            array_push($results, $item);
        }
        $this->lower_error();
        $query_lib["search_user"]->free_result();
        return $results;
    }

    function updatePassword($id, $pass)
    {
        global $query_lib;
        global $con;
        $query_lib["update_password"]->bind_param("si", $pass, $id);
        $query_lib["update_password"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"updatePassword");
            return null;
        }
        if($query_lib["update_password"]->affected_rows < 1)
        {
            $query_lib["update_password"]->free_result();
            return false;
        }
        $this->lower_error();
        return true;
    }

    function unsetUserDeletion($id)
    {
        global $query_lib;
        global $con;

        $query_lib["unmark_user_deletion"]->bind_param("i", $id);
        $query_lib["unmark_user_deletion"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"unsetUserDeletion");
            return null;
        }
        if($query_lib["unmark_user_deletion"]->affected_rows < 1)
        {
            $query_lib["unmark_user_deletion"]->free_result();
            return false;
        }
        $this->lower_error();
        return true;
    }

    function setUserDeletion($id)
    {
        global $query_lib;
        global $con;

        $bomb = Date('Y-m-d H:i:s', strtotime("+7 days"));

        $query_lib["mark_user_deletion"]->bind_param("si", $bomb, $id);
        $query_lib["mark_user_deletion"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"setUserDeletion");
            return null;
        }
        if($query_lib["mark_user_deletion"]->affected_rows < 1)
        {
            $query_lib["mark_user_deletion"]->free_result();
            return false;
        }
        $this->lower_error();
        return true;
    }

    function getBlockingUsers($id, $tuple=false)
    {
        global $query_lib;
        global $con;

        $query_lib["get_blocking_users"]->bind_param("i", $id);
        $query_lib["get_blocking_users"]->execute();
        $res = $query_lib["get_blocking_users"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getBlockingUsers");
            return null;
        }
        if($res->num_rows < 1)
        {
            $query_lib["get_blocking_users"]->free_result();
            return false;
        }

        $users = [];
        while($row = $res->fetch_assoc())
            array_push($users, $row);
        
        $query_lib["get_blocking_users"]->free_result();

        if($tuple)
        {
            $list = "(";
            foreach($users as $user)
                $list .= $user["id"] . ",";
            $list = substr($list, 0, strlen($list)-1);
            $list .= ")";
            if($list == "()")
                return null;
            return [$users, $list];
        }else{return $users;}
    }

    function isBlocking($sid, $usid)
    {
        global $query_lib;
        global $con;

        $userid = $this->getUserDataFromSession($sid, true)["id"];
        $query_lib["check_block"]->bind_param("ii",$userid, $usid);
        $query_lib["check_block"]->execute();
        $res = $query_lib["check_block"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"isBlocking");
            return null;
        }
        if($res->num_rows < 1)
        {
            $query_lib["check_block"]->free_result();
            return false;
        }
        $query_lib["check_block"]->free_result(); 
        return true;
    }

    function unblock($ausid, $busid)
    {
        global $query_lib;
        global $con;

        $query_lib["unblock_user"]->bind_param("ii", $ausid, intval($busid));
        $query_lib["unblock_user"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"unblock");
            return false;
        }else if($query_lib["unblock_user"]->affected_rows < 1)
        {
            return null;
        }
        return true;
    }

    function block($ausid, $busid)
    {
        global $query_lib;
        global $con;

        $query_lib["block_user"]->bind_param("ii", $ausid, intval($busid));
        $query_lib["block_user"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"block");
            return false;
        }else if($query_lib["block_user"]->affected_rows < 1)
        {
            return null;
        }
        return true;
    }

    function getFollowingUsers($id)
    {
        global $query_lib;
        global $con;

        $query_lib["get_following_users"]->bind_param("i", $id);
        $query_lib["get_following_users"]->execute();
        $res = $query_lib["get_following_users"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getFollowingUsers");
            return null;
        }
        if($res->num_rows < 1)
        {
            $query_lib["get_following_users"]->free_result();
            return false;
        }

        $users = [];
        while($row = $res->fetch_assoc())
            array_push($users, $row);
        
        $query_lib["get_following_users"]->free_result();
        return $users;
    }

    function getUserPrivacyOptions($usid)
    {
        global $query_lib;
        global $con;
        
        $query_lib["get_user_privacy"]->bind_param("i", $usid);
        $query_lib["get_user_privacy"]->execute();
        $res = $query_lib["get_user_privacy"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getUserPrivacyOptions");
            return null;
        }
        if($res->num_rows < 1)
        {
            $query_lib["get_user_privacy"]->free_result();
            return false;
        }
        $privacyoptions = $res->fetch_assoc();
        $query_lib["get_user_privacy"]->free_result();
        $this->lower_error();
        return $privacyoptions;
    }

    function removeMedia($id)
    {
        global $query_lib;
        global $con;

        $query_lib["remove_media"]->bind_param("i", $id);
        $query_lib["remove_media"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"removeMedia");
            return null;
        }
        if($query_lib["remove_media"]->affected_rows < 1)
        {
            $query_lib["remove_media"]->free_result();
            return false;
        }
        $this->lower_error();
        return true;
    }

    function getMessage($mesid)
    {
        global $query_lib;
        global $con;

        $query_lib["get_message"]->bind_param("i", $mesid);
        $query_lib["get_message"]->execute();
        $res = $query_lib["get_message"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getMessage");
            return null;
        }
        if($res->num_rows < 1)
        {
            $this->lower_error();
            return false;
        }
        $data = $res->fetch_assoc();
        $query_lib["get_message"]->free_result();
        return $data;
    }

    function repost($usid, $mesid)
    {
        global $query_lib;
        global $con;
        $query_lib["repost"]->bind_param("ii", $usid, $mesid);
        $query_lib["repost"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"repost");
            return null;
        }
        if($query_lib["repost"]->affected_rows < 1)
        {
            $query_lib["repost"]->free_result();
            return false;
        }
        $query_lib["repost"]->free_result();
        return true;
    }

    function getMessageMedia($mid)
    {
        global $query_lib;
        global $con;
        $medialist = [];
        $query_lib["get_message_media"]->bind_param("i", $mid);
        $query_lib["get_message_media"]->execute();
        $res = $query_lib["get_message_media"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getMessageMedia");
            return null;
        }
        if($res->num_rows < 1)
        {
            $this->lower_error();
            return false;
        }
        while($mediaitem = $res->fetch_assoc()){
            array_push($medialist, $mediaitem);
        }
        $query_lib["get_message_media"]->free_result();
        return $medialist;
    }

    function getMedia($mid)
    {
        global $query_lib;
        global $con;

        $query_lib["get_media"]->bind_param("i", $mid);
        $query_lib["get_media"]->execute();
        $res = $query_lib["get_media"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getMedia");
            return null;
        }
        if($res->num_rows < 1)
        {
            $this->lower_error();
            return false;
        }
        $mediaitem = $res->fetch_assoc();
        $query_lib["get_media"]->free_result();
        return $mediaitem;
    }

    function updateMedia($mesid, $url, $mid)
    {
        global $query_lib;
        global $con;

        $query_lib["update_media"]->bind_param("isi", $mesid, $url, $mid);
        $query_lib["update_media"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"updateMedia");
            return null;
        }
        if($query_lib["update_media"]->affected_rows < 1)
        {
            $query_lib["update_media"]->free_result();
            return false;
        }
        $mid = $query_lib["update_media"]->insert_id;
        $query_lib["update_media"]->free_result();
        return $mid;
    }

    function newMedia($type, $url, $width, $height, $size, $length)
    {
        global $query_lib;
        global $con;

        $emptystr = -1;
        $query_lib["register_media"]->bind_param("iisiiii",$emptystr,$type,$url,$width,$height,$size,$length);
        $query_lib["register_media"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"newMedia");
            return null;
        }
        if($query_lib["register_media"]->affected_rows < 1)
        {
            $query_lib["register_media"]->free_result();
            return false;
        }
        $mid = $query_lib["register_media"]->insert_id;
        $query_lib["register_media"]->free_result();
        return $mid;
    }

    function getFollowingList($sid)
    {
        global $query_lib;
        global $con;

        $userdata = $this->getUserDataFromSession($sid, true);
        $userid = $userdata["id"];
        $query_lib["get_user_followers"]->bind_param("i",$userid);
        $query_lib["get_user_followers"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"getFollowingList");
            return null;
        }
        $followers = [$userid];
        $res = $query_lib["get_user_followers"]->get_result();
        while($follow = $res->fetch_assoc())
            array_push($followers, $follow["following"]);
        $query_lib["get_user_followers"]->free_result();
        return $followers;
    }

    function getUserTimeline($start, $count, $sid, $is_sid = true, $my_sid = null, $getliked = false)
    {
        global $query_lib;
        global $con;

        //$this->raise_error("420", "The server is stoned", "getUserTimeline 0 (~243)");
        if($is_sid)
        {
            $followlist = $this->getFollowingList($sid);
            $watchuser = $this->getUserDataFromSession($sid, true);
    
            $follow_tuple = "(";
            foreach($followlist as $follow)
                $follow_tuple .= "$follow,";
            $follow_tuple = substr($follow_tuple, 0, strlen($follow_tuple)-1);
            $follow_tuple .= ")";
    
            if($follow_tuple == "()")
                return null;

            $block_tuple = $this->getBlockingUsers($watchuser["id"], true)[1];
            //die($block_tuple);
            if(!$getliked)
            {
                $query = $con->prepare("SELECT * FROM messages WHERE author IN $follow_tuple".(($block_tuple)?" AND author NOT IN $block_tuple":"")." ORDER BY postdate DESC LIMIT $start,$count");
                //die("Following");                
            }
            else
            {
                $query = $con->prepare("SELECT messages.* FROM likedcontent INNER JOIN messages ON likedcontent.likedmsg = messages.id WHERE likedcontent.user = ? ORDER BY postdate DESC LIMIT $start,$count");
                $query->bind_param("i", $watchuser["id"]);
                //die("Liked only");
            }
                
                //die($con->error);
            $query->execute();
            $res = $query->get_result();
        }else{
            if($my_sid)
                $watchuser = $this->getUserDataFromSession($my_sid, true);
            $query = $con->prepare("SELECT * FROM messages WHERE author = ? ORDER BY postdate DESC");
            $query->bind_param("i", $sid);
            $query->execute();
            $res = $query->get_result();
        }
        //$loops = 0;
        $html = "";
        while($row = $res->fetch_assoc()){
            //echo ($loops = $loops + 1) . "<br>";
            $userdata = $this->getUserFromId($row["author"]);
            //var_dump($userdata);
            $query_lib["getpostlikes"]->bind_param("i", $row["id"]);
            $query_lib["getpostlikes"]->execute();
            $likes = $query_lib["getpostlikes"]->get_result()->fetch_assoc()["likes"];
            $query_lib["getpostlikes"]->free_result();

            $query_lib["checkliked"]->bind_param("i", $row["id"]);
            $query_lib["checkliked"]->execute();
            $isliked = ($query_lib["checkliked"]->get_result()->fetch_assoc()["user"] == $watchuser["id"]);
            $query_lib["checkliked"]->free_result();

            $a = $likes;

            $media = $this->getMessageMedia($row["id"]);

            $avatar = ($userdata["avatar"] == null)?"users/avatars/default.jpg":$userdata["avatar"];
            $msg = preg_replace('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', "<a href=\"#\" class=\"message-tag\">#$1</a>", nl2br($row["content"]));
            $msg = preg_replace('/@([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>¿\?¡!\-\s]{3,20})/', "<a href=\"#\" class=\"message-user\">@$1</a>", $msg);
            $html .= '<div class="message">';

                if($watchuser["id"] != $row["author"])
                {
                    /*Reportar*/
                    $html .= '<i class="fa fa-bars message-dropbutton" msgid="'.$row["id"].'">';
                    $html .= '<div class="message-menu-drop">
                                <div class="message-report">Reportar mensaje</div>
                            </div></i>';
                    /*Reportar*/
                }
            $html .= '<div class="message-header">';
            $html .= '<a href="#"><img src="'.$avatar.'" class="msavatar"></a>';
            $html .= '<span class="message-author"><a href="profile.php?id='.$row["author"].'">'.$userdata["name"].' (@'.$userdata["nick"].')</a></span><br>';
            $html .= '<span class="message-date">'.$row["postdate"].'</span>';
            $html .= '</div>';
            $html .= '<div class="message-body">';
            if($row['shared'] == null)
                $html .= '<p class="message-content">'.$msg.'</p>';
            else{
                $mdat = $this->getMessage($row['shared']);
                $userdata2 = $this->getUserFromId($mdat["author"]);
                $media2 = $this->getMessageMedia($mdat["medialist"]);
                $html .= '<span class="repost-info"><i class="fa fa-retweet"></i> Repost de @'.$userdata2["nick"].' <img src="'.(($userdata2["avatar"]==NULL)?"users/avatars/default.jpg":$userdata2["avatar"]).'" class="retweet-avatar"></span>';
                $msg2 = preg_replace('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', "<a href=\"#\" class=\"message-tag\">#$1</a>", nl2br($mdat["content"]));
                $msg2 = preg_replace('/@([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>¿\?¡!\-\s]{3,20})/', "<a href=\"#\" class=\"message-user\">@$1</a>", $msg2);
                $html .= '<p class="message-content">'.$msg2.'</p>';
                $media2 = $this->getMessageMedia($mdat["id"]);
                if(count($media2) > 0 && $media2[0]){
                    $html .= '<div class="message-media">';
                    switch(count($media))
                    {
                        case 1:
                        $html .= '<a href="'.$media2[0]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[0]['url'].'" class="media-big"/></a>';
                        break;
                        case 2:
                        $html .= '<a href="'.$media2[0]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[0]['url'].'" class="media-med"/></a>';
                        $html .= '<a href="'.$media2[1]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[1]['url'].'" class="media-med"/></a>';
                        break;
                        case 3:
                        $html .= '<a href="'.$media2[0]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[0]['url'].'" class="media-med"/></a>';
                        $html .= '<a href="'.$media2[1]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[1]['url'].'" class="media-small"/></a>';
                        $html .= '<a href="'.$media2[2]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[2]['url'].'" class="media-small"/></a>';
                        break;
                    }
                    $html .= '</div>';
                }
            }
            if(count($media) > 0 && $media[0]){
                $html .= '<div class="message-media">';
                switch(count($media))
                {
                    case 1:
                    $html .= '<a href="'.$media[0]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[0]['url'].'" class="media-big"/></a>';
                    break;
                    case 2:
                    $html .= '<a href="'.$media[0]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[0]['url'].'" class="media-med"/></a>';
                    $html .= '<a href="'.$media[1]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[1]['url'].'" class="media-med"/></a>';
                    break;
                    case 3:
                    $html .= '<a href="'.$media[0]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[0]['url'].'" class="media-med"/></a>';
                    $html .= '<a href="'.$media[1]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[1]['url'].'" class="media-small"/></a>';
                    $html .= '<a href="'.$media[2]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[2]['url'].'" class="media-small"/></a>';
                    break;
                }
                $html .= '</div>';
            }
            if($row["replyto"] != NULL)
            {
                $replymsg = $this->getMessage(intval($row["replyto"]));
                $replyuser = $this->getUserFromId(intval($replymsg["author"]));
                $html .= '<div class="message-reply-info">';
                $html .= '<span class="message-reply-header"><i class="fa fa-mail-reply"></i> En respuesta a @'.$replyuser["nick"].' <img src="'.(($replyuser["avatar"])?$replyuser["avatar"]:"users/avatars/default.jpg").'" class="reply-user-avatar"></span>';
                $html .= '<p class="message-reply-content">'.$replymsg["content"].'</p>';
                $html .= '</div>';
            }
            if($watchuser["id"] != $row["author"])
            {
                $html .= '<div class="message-options">';
                $html .= '<i class="fa fa-mail-reply" rel="'.$row["id"].'" author="'.$userdata["nick"].'"></i>';
                $html .= '<i class="fa fa-retweet" rel="'.$row["id"].'"></i>';
                if(isset($isliked))
                {
                    $html .= '<i class="fa fa-heart'.(($isliked)?" liked-message":"").'" rel="'.$row["id"].'"></i><span class="message-metter">'.$a.'</span>';                
                }
                else
                {
                    $html .= '<i class="fa fa-heart" rel="'.$row["id"].'"></i><span class="message-metter">'.$a.'</span>';               
                }
                $html .= '</div>';
            }
        $html .= '</div></div>';
        }
        $query->free_result();
        $query->close();
        return $html;
    }

    function isFollowing($sid, $usid)
    {
        global $query_lib;
        global $con;

        $userid = $this->getUserDataFromSession($sid, true)["id"];
        $query_lib["check_follow"]->bind_param("ii",$userid, $usid);
        $query_lib["check_follow"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"isFollowing");
            return null;
        }
        if($query_lib["check_follow"]->get_result()->num_rows < 1)
        {
            $query_lib["check_follow"]->free_result();
            return false;
        }
        $query_lib["check_follow"]->free_result(); 
        return true;
    }

    function unfollow($ausid, $busid)
    {
        global $query_lib;
        global $con;

        $query_lib["unfollow_user"]->bind_param("ii", $ausid, intval($busid));
        $query_lib["unfollow_user"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"unfollow");
            return false;
        }else if($query_lib["unfollow_user"]->affected_rows < 1)
        {
            return null;
        }
        return true;
    }

    function follow($ausid, $busid)
    {
        global $query_lib;
        global $con;

        $query_lib["follow_user"]->bind_param("ii", $ausid, intval($busid));
        $query_lib["follow_user"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"follow");
            return false;
        }else if($query_lib["follow_user"]->affected_rows < 1)
        {
            return null;
        }
        return true;
    }

    function getUserDataFromSession($sid, $hidepass = false){
        global $query_lib;
        global $con;

        $query_lib["session_user"]->bind_param("s", $sid);
        $query_lib["session_user"]->execute();
        $res = $query_lib["session_user"]->get_result();
        $userdata = $res->fetch_assoc();
        while($a = $res->fetch_assoc()){
            $a = null;
        }
        $query_lib["session_user"]->free_result();
        $res->free_result();
        /*if($hidepass)
            $userdata["password"] = "";*/
        //var_dump($userdata);
        return $userdata;
    }

    function genericTimeline($start, $count, $sid = NULL)
    {
        global $query_lib;
        global $con;
        
        $blocklist = null;
        if($sid)
        {
            $id = $this->getUserFromSession($sid);
            $blocklist = $this->getBlockingUsers($id["id"], true)[1];
        }

        $query = $con->prepare("SELECT * FROM messages ".(($blocklist)?"WHERE author NOT IN $blocklist ":"")."ORDER BY postdate DESC LIMIT ".$start.",".$count."");
        //die($con->error);
        $query->execute();
        $res = $query->get_result();

        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error,"Timeline");
            return false;
        }

        $html = "";

        $row = $res->fetch_assoc();
        if(!$row)
        {
            $query->free_result();
            //$html .= '<div class="message">';
            //$html .= '<span class="warning">Todavía no hay ningún mensaje.</span>';
            //$html .= '</div>';
            return $html;
        }
        do{
            //echo ($loops = $loops + 1) . "<br>";
            $userdata = $this->getUserFromId($row["author"]);
            //var_dump($userdata);
            $query_lib["getpostlikes"]->bind_param("i", $row["id"]);
            $query_lib["getpostlikes"]->execute();
            $likes = $query_lib["getpostlikes"]->get_result()->fetch_assoc()["likes"];
            $query_lib["getpostlikes"]->free_result();

            $query_lib["checkliked"]->bind_param("i", $row["id"]);
            $query_lib["checkliked"]->execute();
            if(isset($id))
                $isliked = ($query_lib["checkliked"]->get_result()->fetch_assoc()["user"] == $id["id"]);
            $query_lib["checkliked"]->free_result();

            $a = $likes;

            $media = $this->getMessageMedia($row["id"]);

            $avatar = ($userdata["avatar"] == null)?"users/avatars/default.jpg":$userdata["avatar"];
            $msg = preg_replace('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', "<a href=\"#\" class=\"message-tag\">#$1</a>", nl2br($row["content"]));
            $msg = preg_replace('/@([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>¿\?¡!\-\s]{3,20})/', "<a href=\"#\" class=\"message-user\">@$1</a>", $msg);
            $html .= '<div class="message">';
            $html .= '<div class="message-header">';
            
            if(isset($id))
            {
                if($id != $row["author"])
                {
                    /*Reportar*/
                    $html .= '<i class="fa fa-bars message-dropbutton" msgid="'.$row["id"].'">';
                    $html .= '<div class="message-menu-drop">
                                <div class="message-report">Reportar mensaje</div>
                            </div></i>';
                    /*Reportar*/
                }
            }

            $html .= '<a href="#"><img src="'.$avatar.'" class="msavatar"></a>';
            $html .= '<span class="message-author"><a href="profile.php?id='.$row["author"].'">'.$userdata["name"].' (@'.$userdata["nick"].')</a></span><br>';
            $html .= '<span class="message-date">'.$row["postdate"].'</span>';
            $html .= '</div>';
            $html .= '<div class="message-body">';
            if($row['shared'] == null)
                $html .= '<p class="message-content">'.$msg.'</p>';
            else{
                $mdat = $this->getMessage($row['shared']);
                $userdata2 = $this->getUserFromId($mdat["author"]);
                $media2 = $this->getMessageMedia($mdat["medialist"]);
                $html .= '<span class="repost-info"><i class="fa fa-retweet"></i> Repost de @'.$userdata2["nick"].' <img src="'.(($userdata2["avatar"]==NULL)?"users/avatars/default.jpg":$userdata2["avatar"]).'" class="retweet-avatar"></span>';
                $msg2 = preg_replace('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', "<a href=\"#\" class=\"message-tag\">#$1</a>", nl2br($mdat["content"]));
                $msg2 = preg_replace('/@([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>¿\?¡!\-\s]{3,20})/', "<a href=\"#\" class=\"message-user\">@$1</a>", $msg2);
                
                $html .= '<p class="message-content">'.$msg2.'</p>';
                $media2 = $this->getMessageMedia($mdat["id"]);
                if(count($media2) > 0 && $media2[0]){
                    $html .= '<div class="message-media">';
                    switch(count($media))
                    {
                        case 1:
                        $html .= '<a href="'.$media2[0]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[0]['url'].'" class="media-big"/></a>';
                        break;
                        case 2:
                        $html .= '<a href="'.$media2[0]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[0]['url'].'" class="media-med"/></a>';
                        $html .= '<a href="'.$media2[1]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[1]['url'].'" class="media-med"/></a>';
                        break;
                        case 3:
                        $html .= '<a href="'.$media2[0]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[0]['url'].'" class="media-med"/></a>';
                        $html .= '<a href="'.$media2[1]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[1]['url'].'" class="media-small"/></a>';
                        $html .= '<a href="'.$media2[2]['url'].'" data-lightbox="'.$media2[0]['message'].'"><img src="'.$media2[2]['url'].'" class="media-small"/></a>';
                        break;
                    }
                    $html .= '</div>';
                }
            }
            if(count($media) > 0 && $media[0]){
                $html .= '<div class="message-media">';
                switch(count($media))
                {
                    case 1:
                    $html .= '<a href="'.$media[0]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[0]['url'].'" class="media-big"/></a>';
                    break;
                    case 2:
                    $html .= '<a href="'.$media[0]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[0]['url'].'" class="media-med"/></a>';
                    $html .= '<a href="'.$media[1]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[1]['url'].'" class="media-med"/></a>';
                    break;
                    case 3:
                    $html .= '<a href="'.$media[0]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[0]['url'].'" class="media-med"/></a>';
                    $html .= '<a href="'.$media[1]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[1]['url'].'" class="media-small"/></a>';
                    $html .= '<a href="'.$media[2]['url'].'" data-lightbox="'.$media[0]['message'].'"><img src="'.$media[2]['url'].'" class="media-small"/></a>';
                    break;
                }
                $html .= '</div>';
            }
            if($row["replyto"] != NULL)
            {
                $replymsg = $this->getMessage(intval($row["replyto"]));
                $replyuser = $this->getUserFromId(intval($replymsg["author"]));
                $html .= '<div class="message-reply-info">';
                $html .= '<span class="message-reply-header"><i class="fa fa-mail-reply"></i> En respuesta a @'.$replyuser["nick"].' <img src="'.(($replyuser["avatar"])?$replyuser["avatar"]:"users/avatars/default.jpg").'" class="reply-user-avatar"></span>';
                $html .= '<p class="message-reply-content">'.$replymsg["content"].'</p>';
                $html .= '</div>';
            }
            if(isset($id))
            {
                if($id != $row["author"])
                {
                    $html .= '<div class="message-options">';
                    $html .= '<i class="fa fa-mail-reply" rel="'.$row["id"].'" author="'.$userdata["nick"].'"></i>';
                    $html .= '<i class="fa fa-retweet" rel="'.$row["id"].'"></i>';
                    if(isset($isliked))
                        $html .= '<i class="fa fa-heart'.(($isliked)?" liked-message":"").'" rel="'.$row["id"].'"></i><span class="message-metter">'.$a.'</span>';
                    else
                        $html .= '<i class="fa fa-heart" rel="'.$row["id"].'"></i><span class="message-metter">'.$a.'</span>';
                    $html .= '</div>';
                }
            }
            

            $html .= '</div></div>';
            //var_dump($html);
        }while($row = $res->fetch_assoc());

        $query->free_result();

        return $html;
    }

    function endsession($sid)
    {
        $sid = substr($sid, 0, 50);
        global $query_lib;
        global $con;
        $query_lib["endsession"]->bind_param("s",$sid);
        $query_lib["endsession"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "endsession");
            return false;
        }
        if($query_lib["endsession"]->affected_rows < 1)
        {
            $this->lower_error();
            die($sid);
            return null;
        }
    }

    function getUserFromId($usid)
    {
        global $query_lib;
        global $con;
        $query_lib["get_user_from_id"]->bind_param("i", $usid);
        $query_lib["get_user_from_id"]->execute();
        $res = $query_lib["get_user_from_id"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "getUserFromId");
            $query_lib["setavatar"]->close();
            return false;
        }
        $usdata = $res->fetch_assoc();
        $query_lib["get_user_from_id"]->free_result();
        $usdata["password"] = null;
        return $usdata;
    }

    function getAvatar($id)
    {
        global $query_lib;
        global $con;
        $query_lib["getavatar"]->bind_param("i",$id);
        $query_lib["getavatar"]->execute();
        $res = $query_lib["getavatar"]->get_result()->fetch_assoc()["avatar"];
        $query_lib["getavatar"]->free_result();
        return $res;
    }

    function setUserAvatar($url, $usid)
    {
        global $query_lib;
        global $con;
        $query_lib["setavatar"]->bind_param("si", $url, $usid);
        $query_lib["setavatar"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "setUserAvatar");
            //$query_lib["setavatar"]->close();
            return false;
        }
        if($query_lib["setavatar"]->affected_rows < 1)
        {
            $this->lower_error();
            //$query_lib["setavatar"]->close();
            die("No result");
            return null;
        }
        return true;
    }

    function setTabledataField($table, $field, $value, $usid)
    {
        global $query_lib;
        global $con;
        $query = $con->prepare("UPDATE " . $table . " SET " . $field . " = ? WHERE id = ?");
        $query->bind_param("si",$value,$usid);
        $query->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "setTabledataField");
            $query->close();
            return false;
        }
        if($query->affected_rows < 1)
        {
            $this->lower_error();
            $query->close();
            die("No result");
            return null;
        }
        $query->close();
        return true;
    }

    function setUserdataField($field, $value, $usid)
    {
        global $query_lib;
        global $con;
        $query = $con->prepare("UPDATE userdata SET " . $field . " = ? WHERE id = ?");
        $query->bind_param("si",$value,$usid);
        $query->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "setUserdataField");
            $query->close();
            return false;
        }
        if($query->affected_rows < 1)
        {
            $this->lower_error();
            $query->close();
            die("No result");
            return null;
        }
        $query->close();
        return true;
    }

    function getHotTopics()
    {
        global $query_lib;
        global $con;
        $query_lib["get_hot_topics"]->execute();
        $res = $query_lib["get_hot_topics"]->get_result();

        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "getHotTopics");
            return false;
        }

        $topics = "";
        $topic = $res->fetch_assoc();
        if(!$topic)
        {
            $query_lib["get_hot_topics"]->free_result();
            $topics = '<span class="warning">No hay ningún tópico.</span>';
            return $topics;
        }
        do{
            $topics .= "<li><a href=\"#\">#".$topic["name"]."</a><span class=\"a1\">(".$topic["mentions"]." menciones)</span></li>";
        }while($topic = $res->fetch_assoc());

        $query_lib["get_hot_topics"]->free_result();
        return $topics;
    }

    function likeMessage($sesid, $mesid)
    {
        global $query_lib;
        global $con;

        $query_lib["get_user_from_session"]->bind_param("i", $sesid);
        $query_lib["get_user_from_session"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "likeMessage 1");
            //die("Whoops! Hay un error (".$con->errno."): " . $con->error);
            return false;
        }
        $uid = $query_lib["get_user_from_session"]->get_result()->fetch_assoc()["userid"];
        $query_lib["get_user_from_session"]->free_result();

        $query_lib["likemessage"]->bind_param("ii", $mesid, $uid);
        $query_lib["likemessage"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "likeMessage 2");
            //die("Whoops! Hay un error (".$con->errno."): " . $con->error);
            return false;
        }
        if($query_lib["likemessage"]->affected_rows < 1)
        {
            $this->lower_error();
            die("4");
            return null;
        }

        $query_lib["updatepostlikes"]->bind_param("i", $mesid);
        $query_lib["updatepostlikes"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "likeMessage 3");
            //die("Whoops! Hay un error (".$con->errno."): " . $con->error);
            return false;
        }
        if($query_lib["likemessage"]->affected_rows < 1)
        {
            $this->lower_error();
            die("4");
            return null;
        }

        return true;
    }

    function registerTag($tname, $pid)
    {
        global $query_lib;
        global $con;

        $query_lib["get_tag"]->bind_param("s", $tname);
        $query_lib["get_tag"]->execute();
        $res = $query_lib["get_tag"]->get_result();
        if($res->num_rows > 0)
        {
            $this->lower_error();
            $query_lib["increase_tag_count"]->bind_param("s", $tname);
            $query_lib["increase_tag_count"]->execute();
            
            $query_lib["bind_tag"]->bind_param("ii", $pid, $res->fetch_assoc()["id"]);
            $query_lib["bind_tag"]->execute();
    
            if($con->errno != 0)
            {
                $this->raise_error($con->errno, $con->error, "registerTag 1");
                //die("Whoops! Hay un error (".$con->errno."): " . $con->error);
                return false;
            }
            if($query_lib["bind_tag"]->affected_rows < 1)
            {
                $this->lower_error();
                die("4");
                return null;
            }

            /*if($con->errno != 0)
                die("Whoops! Hay un error (".$con->errno."): " . $con->error);*/
            return false;
        }
        $query_lib["get_tag"]->free_result();

        $query_lib["register_tag"]->bind_param("s", $tname);
        $query_lib["register_tag"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "registerTag 2");
            //die("Whoops! Hay un error (".$con->errno."): " . $con->error);
            return false;
        }
        if($query_lib["register_tag"]->affected_rows < 1)
        {
            $this->lower_error();
            die("3");
            return null;
        }

        $tid = $query_lib["register_tag"]->insert_id;
        //die("-- " . $tid . " <> " . $pid);

        $query_lib["bind_tag"]->bind_param("ii", $pid, $tid);
        $query_lib["bind_tag"]->execute();

        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "registerTag 3");
            //die("Whoops! Hay un error (".$con->errno."): " . $con->error);
            return false;
        }
        if($query_lib["bind_tag"]->affected_rows < 1)
        {
            $this->lower_error();
            die("4");
            return null;
        }

        return true;
    }

/*    function getTimeline($start, $count)
    {
        global $query_lib;
        global $con;
        
        $query_lib["get-timeline"]->bind_param("ii", $start, $count);
        $query_lib["get-timeline"]->execute();
        $res = $query_lib["get-timeline"]->get_result();

        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "getTimeline");
            return false;
        }

        $html = "";

        $row = $res->fetch_assoc();
        if(!$row)
        {
            $query_lib["get-timeline"]->free_result();
            $html .= '<div class="message">';
            $html .= '<span class="warning">Todavía no hay ningún mensaje.</span>';
            $html .= '</div>';
            return $html;
        }
        do{
            //die("-- AUTHOR: " . $row["author"]);
            $query_lib["get_user_from_id"]->bind_param("i", $row["author"]);
            $query_lib["get_user_from_id"]->execute();
            $res2 = $query_lib["get_user_from_id"]->get_result();
            $userdata = $res2->fetch_assoc();
            $query_lib["get_user_from_id"]->free_result();

            $query_lib["getpostlikes"]->bind_param("i", $row["id"]);
            $query_lib["getpostlikes"]->execute();
            $likes = $query_lib["getpostlikes"]->get_result()->fetch_assoc()["likes"];
            $query_lib["getpostlikes"]->free_result();

            $query_lib["checkliked"]->bind_param("i", $row["id"]);
            $query_lib["checkliked"]->execute();
            $isliked = ($query_lib["checkliked"]->get_result()->fetch_assoc()["user"] == $userdata["id"]);

            $media = $this->getMessageMedia($row["id"]);

            $avatar = ($userdata["avatar"] == null)?"users/avatars/default.jpg":$userdata["avatar"];
            $a = $likes;
            if($likes > 1000 && $likes < 999999)
                $a = str_replace(".", "K", ("" . round($likes / 1000, 2)));
            else if($likes > 1000000 && $likes < 999999999)
                $a = str_replace(".", "M", ("" . round($likes / 1000000, 2)));
            else if($likes > 1000000000)
                $a = str_replace(".", "B", ("" . round($likes / 1000000, 2)));

            $msg = preg_replace('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', "<a href=\"#\" class=\"message-tag\">#$1</a>", nl2br($row["content"]));
            $msg = preg_replace('/@([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>¿\?¡!\-\s]{3,20})/', "<a href=\"#\" class=\"message-user\">@$1</a>", $msg);
            $html .= '<div class="message">';
            $html .= '<div class="message-header">';
            $html .= '<a href="#"><img src="'.$avatar.'" class="msavatar"></a>';
            $html .= '<span class="message-author"><a href="#">'.$userdata["name"].' (@'.$userdata["nick"].')</a></span><br>';
            $html .= '<span class="message-date">'.$row["postdate"].'</span>';
            $html .= '</div>';
            $html .= '<div class="message-body">';
            $html .= '<p class="message-content">'.$msg.'</p>';
            if($row['shared'] == null)
                $html .= '<p class="message-content">'.$msg.'</p>';
            else{
                $mdat = $this->getMessage($row['shared']);
                $userdata2 = $this->getUserFromId($mdat["author"]);
                $media2 = $this->getMessageMedia($mdat["medialist"]);
                $html .= '<span class="repost-info"><i class="fa fa-retweet"></i> Repost de @'.$userdata2["nick"].' <img src="'.(($userdata2["avatar"]==NULL)?"users/avatars/default.jpg":$userdata2["avatar"]).'" class="retweet-avatar"></span>';
                $msg2 = preg_replace('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', "<a href=\"#\" class=\"message-tag\">#$1</a>", nl2br($mdat["content"]));
                $msg2 = preg_replace('/@([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>¿\?¡!\-\s]{3,20})/', "<a href=\"#\" class=\"message-user\">@$1</a>", $msg2);
                $html .= '<p class="message-content">'.$msg2.'</p>';
                $media2 = $this->getMessageMedia($mdat["id"]);
                if(count($media2) > 0 && $media2[0]){
                    $html .= '<div class="message-media">';
                    switch(count($media))
                    {
                        case 1:
                        $html .= '<img src="'.$media2[0]['url'].'" class="media-big"/>';
                        break;
                        case 2:
                        $html .= '<img src="'.$media2[0]['url'].'" class="media-med"/>';
                        $html .= '<img src="'.$media2[1]['url'].'" class="media-med"/>';
                        break;
                        case 3:
                        $html .= '<img src="'.$media2[0]['url'].'" class="media-med"/>';
                        $html .= '<img src="'.$media2[1]['url'].'" class="media-small"/>';
                        $html .= '<img src="'.$media2[2]['url'].'" class="media-small"/>';
                        break;
                    }
                    $html .= '</div>';
                }
            }
            if(count($media) > 0){
                $html .= '<div class="message-media">';
                switch(count($media) && $media[0])
                {
                    case 1:
                    $html .= '<img src="'.$media[0]['url'].'" class="media-big"/>';
                    break;
                    case 2:
                    $html .= '<img src="'.$media[0]['url'].'" class="media-med"/>';
                    $html .= '<img src="'.$media[1]['url'].'" class="media-med"/>';
                    break;
                    case 3:
                    $html .= '<img src="'.$media[0]['url'].'" class="media-med"/>';
                    $html .= '<img src="'.$media[1]['url'].'" class="media-small"/>';
                    $html .= '<img src="'.$media[2]['url'].'" class="media-small"/>';
                    break;
                }
                $html .= '</div>';
            }
            $html .= '<div class="message-options">';
            $html .= '<i class="fa fa-mail-reply" rel="'.$row["id"].'"></i>';
            $html .= '<i class="fa fa-retweet" rel="'.$row["id"].'"></i>';
            $html .= '<i class="fa fa-heart'.(($isliked)?" liked-message":"").'" rel="'.$row["id"].'"></i><span class="message-metter">'.$a.'</span>';
            $html .= '</div></div></div>';
        }while($row = $res->fetch_assoc());

        $query_lib["get-timeline"]->free_result();

        return $html;
    }*/

    function postMessage($sid, $message, $filemedialist = null, $replyto = null)
    {
        global $query_lib;
        global $con;

        //var_dump($filemedialist);

        $zero = 0;
        $nl = null;
        $query_lib["get_user_from_session"]->bind_param("s", $sid);
        $query_lib["get_user_from_session"]->execute();
        $res = $query_lib["get_user_from_session"]->get_result();

        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "postMessage 1");
            return false;
        }
        
        $usid = $res->fetch_assoc()["userid"];
        $query_lib["get_user_from_session"]->free_result();

        $query_lib["get_user_from_id"]->bind_param("i", $usid);
        $query_lib["get_user_from_id"]->execute();
        $res2 = $query_lib["get_user_from_id"]->get_result();
        $userdata = $res2->fetch_assoc();
        $query_lib["get_user_from_id"]->free_result();

        $query_lib["post-message"]->bind_param("issiiis",
            $usid,
            $message,
            $filemedialist,
            $zero,
            $nl,
            $replyto,
            $nl
        );
        
        $query_lib["post-message"]->execute();

        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "postMessage 2");
            return false;
        }else if($query_lib["post-message"]->affected_rows < 1)
        {
            return null;
        }
        $postid = $query_lib["post-message"]->insert_id;
        $this->lower_error();

        $media = [];
        if($filemedialist)
        {
            $medias = explode(",",trim($filemedialist));
            $usermediafolder = "media/".$userdata["id"]."/";
            if(!file_exists($usermediafolder))
                mkdir($usermediafolder);
            foreach($medias as $mediaitem)
            {
                $mitinfo = $this->getMedia($mediaitem);
                $fname = str_replace("media/temp/", $usermediafolder, $mitinfo["url"]);
                rename($mitinfo["url"], $fname);
                //unlink($mitinfo["url"]);
                $this->updateMedia($postid, $fname, $mediaitem);
                array_push($media, ["url" => $fname]);
            }
        }

        $avatar = ($userdata["avatar"] == null)?"users/avatars/default.jpg":$userdata["avatar"];
        $msg = preg_replace('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', "<a href=\"#\" class=\"message-tag\">#$1</a>", nl2br($message));
        $html = '<div class="message">';
        $html .= '<div class="message-header">';
        $html .= '<a href="#"><img src="'.$avatar.'" class="msavatar"></a>';
        $html .= '<span class="message-author"><a href="#">'.$userdata["name"].' (@'.$userdata["nick"].')</a></span><br>';
        $html .= '<span class="message-date">'.date('Y-m-d H:i:s', time()).'</span>';
        $html .= '</div>';
        $html .= '<div class="message-body">';
        $html .= '<p class="message-content">'.nl2br($msg).'</p>';

        if(count($media) > 0 && $media[0]){
            $html .= '<div class="message-media">';
            switch(count($media))
            {
                case 1:
                $html .= '<img src="'.$media[0]['url'].'" class="media-big"/>';
                break;
                case 2:
                $html .= '<img src="'.$media[0]['url'].'" class="media-med"/>';
                $html .= '<img src="'.$media[1]['url'].'" class="media-med"/>';
                break;
                case 3:
                $html .= '<img src="'.$media[0]['url'].'" class="media-med"/>';
                $html .= '<img src="'.$media[1]['url'].'" class="media-small"/>';
                $html .= '<img src="'.$media[2]['url'].'" class="media-small"/>';
                break;
            }
            $html .= '</div>';
        }

        $html .= '<div class="message-options">';
        $html .= '<i class="fa fa-mail-reply"></i>';
        $html .= '<i class="fa fa-retweet"></i>';
        $html .= '<i class="fa fa-heart"></i>';
        $html .= '</div></div></div>';

        return [$html, $postid];
    }

    function getUserFromSession($sid)
    {
        global $query_lib;
        global $con;

        $query_lib["get_user_from_session"]->bind_param("s", $sid);
        $query_lib["get_user_from_session"]->execute();
        $res = $query_lib["get_user_from_session"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "getUserFromSession 1");
            return null;
        }
        $usid = $res->fetch_assoc()["userid"];
        $query_lib["get_user_from_session"]->free_result();
        //$query_lib["get_user_from_session"]->close();

        $query_lib["get_user_from_id"]->bind_param("i", $usid);
        $query_lib["get_user_from_id"]->execute();
        $res = $query_lib["get_user_from_id"]->get_result();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "getUserFromSession 2");
            return null;
        }
        $usdata = $res->fetch_assoc();

        $query_lib["get_user_from_id"]->free_result();
        //$query_lib["get_user_from_id"]->close();
        return $usdata;
    }

    function login_data($username, $password)
    {
        global $query_lib;
        global $con;

        $query_lib["login_user"]->bind_param("ss", $username, $password);
        $query_lib["login_user"]->execute();
        //$query_lib["login_user"]->store_result();
        $result = $query_lib["login_user"]->get_result();
        $userdata = $result->fetch_assoc();

        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "login_data 1");
            return false;
        }else if($con->errno == 0 && $result->num_rows < 1)
        {
            $this->lower_error();
            return false;
        }
            
        $sid = substr(("s" . md5(rand(9999,99999999)) . md5(rand(9999,99999999)) . md5(rand(1,100))), 0, 50);
        $dn = date("Y-m-d H:i:s", strtotime(' + 30 days'));
        $ba = "Unknown";
        $ip = "0.1.2.3";

        $query_lib["make_session"]->bind_param("sssss",
        $userdata["id"],
        $sid,
        $dn,
        $ba,
        $ip
        );
        $query_lib["login_user"]->free_result();
        $query_lib["login_user"]->close();
        $query_lib["make_session"]->execute();
        $result2 = $query_lib["make_session"]->get_result();

        if($query_lib["make_session"]->affected_rows < 1)
        {
            $this->raise_error($con->errno, $con->error, "login_data 2");
            return false;
        }

        $this->lower_error();
        return $sid;
    }

    function register_new_user($userdata)
    {
        global $con;
        global $query_lib;
        global $HASH;

        if(count($userdata) < 15)
        {
            $this->raise_error(0, "No data providen", "register_new_user 1");
            return false;
        }
        $ut = 0;

        $md1 = md5($userdata["password"]);
        $md2 = md5($HASH);
        $password = md5($md2 . $md1);

        $query_lib["reg_new_user"]->bind_param("ssssssssssiiiisi",
        $userdata["nick"],
        $userdata["name"],
        $userdata["surname"],
        $password,
        $userdata["birthdate"],
        $userdata["gender"],
        $userdata["address"],
        $userdata["phone"],
        $userdata["nationality"],
        $userdata["mail"],
        $userdata["eula"],
        $userdata["news"],
        $userdata["cookies"],
        $userdata["privacy"],
        $userdata["avatar"],
        $ut);

        $query_lib["reg_new_user"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "register_new_user 2");
            $query->close();
            return false;
        }
        if($query_lib["reg_new_user"]->affected_rows < 1)
        {
            $this->raise_error($query_lib["reg_new_user"]->affected_rows, htmlentities($query_lib["reg_new_user"]->error), "register_new_user 3");
            return false;
        }
        $usid = $query_lib["reg_new_user"]->insert_id;
        $query_lib["reg_new_user"]->free_result();

        $query_lib["create_user_privacy"]->bind_param("i", $usid);
        $query_lib["create_user_privacy"]->execute();
        if($con->errno != 0)
        {
            $this->raise_error($con->errno, $con->error, "register_new_user 2");
            $query->close();
            return false;
        }
        if($query_lib["create_user_privacy"]->affected_rows < 1)
        {
            $this->raise_error($query_lib["create_user_privacy"]->affected_rows, htmlentities($query_lib["create_user_privacy"]->error), "register_new_user 4");
            return false;
        }
        $this->lower_error();
        return true;
    }

    function closeall()
    {
        global $query_lib;
        foreach($query_lib as $q)
            $q->close();
    }
}

$qlib = new qlib();

?>
