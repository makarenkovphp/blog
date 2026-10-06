<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database/seeders/DatabaseSeeder.php';

$seeder = new DatabaseSeeder();
$seeder->run();

