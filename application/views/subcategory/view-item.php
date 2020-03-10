<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $Subcategory->name ?>
    <span>
        <?= $User->returnIfAllowed("admin/subcategory/edit",
            "<a class='btn btn-warning btn-sm' href=" . \ItForFree\SimpleMVC\Url::link("admin/subcategory/edit&id=". $Subcategory->id)
            . ">[Редактировать]</a>");?>
    </span>
</h2>
<div class="card" style="width: 100%; min-width: 320px; margin-bottom: 80px">
    <div class="card-body">
        <p>Описание: <?= $Subcategory->description ?></p>
    </div>
</div>
