<?php

use Support\Vault\Config\Framework;
use Support\Vault\Routing\Route;

Route::get('web/framework', [Framework::class, 'index']);