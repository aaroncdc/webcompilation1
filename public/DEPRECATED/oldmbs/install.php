<?php
require("res/connect.php");
mysql_query("CREATE DATABASE `webdata`");
mysql_query(" CREATE TABLE `webdata`.`entradas` (`id` INT NOT NULL AUTO_INCREMENT ,`titulo` VARCHAR( 140 ) NOT NULL ,`fecha` DATE NOT NULL ,`contenido` VARCHAR( 9999999 ) NOT NULL ,`tags` VARCHAR( 100 ) NOT NULL ,PRIMARY KEY ( `id` ))");
mysql_query("CREATE TABLE `webdata`.`comentarios` (`id` INT NOT NULL AUTO_INCREMENT ,`nent` INT( 255 ) NOT NULL ,`pid` INT( 255 ) NOT NULL ,`nombre` VARCHAR( 20 ) NOT NULL ,`mail` VARCHAR( 50 ) NOT NULL ,`web` VARCHAR( 60 ) NOT NULL ,`contenido` VARCHAR( 1000 ) NOT NULL ,`karma` INT( 255 ) NOT NULL,PRIMARY KEY ( `id` ))");
echo mysql_error();
echo "<br/>PROGRAMA FINALIZADO";
?>
