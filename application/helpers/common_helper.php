<?php 

if (!function_exists('debug')) {

    function debug($array = array()) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        exit;
    }
}

?>
