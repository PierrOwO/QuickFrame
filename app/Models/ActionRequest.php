<?php
namespace App\Models;
use Support\Vault\Sanctum\Model;

class ActionRequest extends Model {

    protected static $table = 'action_requests';

    protected static $fillable = [
        'user',
        'type',
        'token',
        'token_hash',
        'email',
        'payload',
        'used',
        'expires_at',
    ];

}