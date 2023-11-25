<?php

/**
 * I decided to publish my code concepts
 */

function dbg($data = '')
{
    // var_dump($data);
    echo "<br /><pre>";
    print_r($data);
    echo "</pre><br />";
    // var_dump($data);
    echo 'Script execution Time is :::: ' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
    exit();
}
