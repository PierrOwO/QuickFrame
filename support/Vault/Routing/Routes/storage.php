<?php

use Support\Vault\Routing\Route;
use Support\Vault\Sanctum\Storage;

Route::get('assets/public/{path:.+}', [Storage::class, 'serve']);