<?php

namespace Support\Vault\Database;

abstract class Migration
{
    abstract public function up();
    abstract public function down();
}