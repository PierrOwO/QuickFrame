<?php

use Support\Core\View;

function redirect($url)
{
    header("Location: $url");
    exit();
}
function view(string $view, array $data = []) {
    //ob_start();
    View::render($view, $data);
   // return ob_get_clean();
}
