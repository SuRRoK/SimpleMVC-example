<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

<h2><?= $viewAdminusers->login ?>
    <span>
        <?= $User->returnIfAllowed("admin/adminusers/edit",
            "<a class=\"btn btn-warning btn-sm\" href=" . \ItForFree\SimpleMVC\Url::link("admin/adminusers/edit&id=". $viewAdminusers->id)
            . ">[Редактировать]</a>");?>
    </span>
</h2>
<div class="card" style="width: 100%; min-width: 320px; margin-bottom: 80px">
    <div class="card-body">
        <p>Зарегистрирован <?= $viewAdminusers->timestamp ?></p>
        <p>E-mail: <?= $viewAdminusers->email ?></p>
        <p>Role: <?= $viewAdminusers->role ?></p>
    </div>
</div>