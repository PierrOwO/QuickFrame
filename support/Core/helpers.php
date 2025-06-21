<?php

use Support\Core\View;

function redirect($url)
{
    header("Location: $url");
    exit();
}
function view(string $view, array $data = []) {
    View::render($view, $data);
}
