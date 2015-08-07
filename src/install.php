<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require __DIR__.'/views/boomcms/installer/install.php';
    exit;
} elseif ($installer->databaseNeedsInstall()) {
    $installer->installDatabase($_POST);
}
