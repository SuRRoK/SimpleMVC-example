<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $Article->name ?>
    <span class="small">
        <?= $User->returnIfAllowed("admin/article/edit",
            "<a href=" . \ItForFree\SimpleMVC\Url::link("admin/article/edit&id=". $Article->id)
            . ">[Редактировать]</a>");?>
    </span>
</h2> 

<p>Описание: <?= $Article->description ?></p>
