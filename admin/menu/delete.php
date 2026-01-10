<?php
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/utils/Security.php';
require_once __DIR__ . '/../../src/controllers/MenuController.php';

session_start();
$db = getDatabaseConnection();
$controller = new MenuController($db);
$controller->delete();

