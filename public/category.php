<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\CategoryController;
use App\Database\Connection;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Smarty\Smarty;

$pdo = Connection::get();

$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '/../templates');
$smarty->setCompileDir(__DIR__ . '/../var/smarty');

$controller = new CategoryController(
    $smarty,
    new CategoryRepository($pdo),
    new PostRepository($pdo)
);

$controller->index();
