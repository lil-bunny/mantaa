<?php

/**

 * Write code on Method

 *

 * @return response()

 */

if (! function_exists('obfuscate_email')) {

    function obfuscate_email($email) {
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        $len  = floor(strlen($name)/2);

        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
    }

}