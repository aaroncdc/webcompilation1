<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$charstr = "1234567890qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM1234567890";

function genhash() {
    global $charstr;
    global $result;
    for($x = 0; $x < 32; $x++)
    {
        $result .= $charstr[rand(0,strlen($charstr)-1)];
    }
    return $result;
}