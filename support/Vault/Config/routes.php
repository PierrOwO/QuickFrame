<?php

use Support\Vault\Routing\Route;


if (!Route::loadCache()) {
    require base_path('routes/api.php');
    Route::saveCache();    
}

require base_path('routes/web.php');

require base_path('support/Vault/Routing/Routes/framework.php');

require base_path('support/Vault/Routing/Routes/actionRequests.php');

require base_path('support/Vault/Routing/Routes/user.php');
require base_path('support/Vault/Routing/Routes/auth.php');

require base_path('support/Vault/Routing/Routes/migrations.php');
require base_path('support/Vault/Routing/Routes/seeders.php');

require base_path('support/Vault/Routing/Routes/storage.php');

Route::dispatch();