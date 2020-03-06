<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

<h2><?= $viewAdminusers->login ?>
    <span class="small">
        <?= $User->returnIfAllowed("admin/adminusers/edit",
            "<a href=" . \ItForFree\SimpleMVC\Url::link("admin/adminusers/edit&id=". $viewAdminusers->id)
            . ">[Редактировать]</a>");?>
    </span>
</h2>

<p>Зарегистрирован <?= $viewAdminusers->timestamp ?></p>
<p>E-mail: <?= $viewAdminusers->email ?></p>
<p>Role: <?= $viewAdminusers->role ?></p>