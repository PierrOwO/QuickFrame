<?php

namespace Support\Core\Database;

abstract class Migration
{
    abstract public function up();
    abstract public function down();
}