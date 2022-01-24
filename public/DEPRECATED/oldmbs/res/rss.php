<?php
require("connect.php");
   require("rssvar.php");
      
$result = mysql_query('SELECT id, titulo, fecha FROM entradas');
echo mysql_error();
$row = mysql_fetch_array($result);
echo mysql_error();
header('Content-type: text/xml; charset="iso-8859-1"', true);

      echo '<?xml version="1.0" encoding="iso-8859-1"?>';
      echo '<rss version="0.92">
           <channel>
                <docs>res/rss.php</docs>
                <title>'.$rss_titulo.'</title>
                <link>'.$rss_url.'</link>
                <description>'.$rss_descripcion.'</description>
                <language>es</language>
                <managingEditor>'.$rss_email.'</managingEditor>
                <webMaster>'.$rss_email.'</webMaster>';
      do {
           echo "<item>";
           echo "<title>" . $row['titulo'] . "</title>";
           echo "<link>".$rss_url."?entry=".$row['id']."</link>";
           echo "<description>".$row['contenido']."</description>";
           echo "</item>";
      } while ($row = mysql_fetch_array($result));
      echo "</channel>";
      echo "</rss>";   
      ?>

