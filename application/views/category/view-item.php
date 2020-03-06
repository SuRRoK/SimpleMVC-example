<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $viewCategory->name ?>
    <span class="small">
        <?= $User->returnIfAllowed("admin/category/edit",
            "<a href=" . \ItForFree\SimpleMVC\Url::link("admin/category/edit&id=". $viewCategory->id)
            . ">[Редактировать]</a>");?>
    </span>
</h2> 

<p>Описание: <?= $viewCategory->description ?></p>
