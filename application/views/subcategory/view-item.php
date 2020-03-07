<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $Subcategory->name ?>
    <span class="small">
        <?= $User->returnIfAllowed("admin/subcategory/edit",
            "<a href=" . \ItForFree\SimpleMVC\Url::link("admin/subcategory/edit&id=". $Subcategory->id)
            . ">[Редактировать]</a>");?>
    </span>
</h2> 

<p>Описание: <?= $Subcategory->description ?></p>
