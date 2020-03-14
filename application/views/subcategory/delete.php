<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $title ?></h2>

<form method="post" action="<?= $Url::link("admin/subcategory/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить подкатегорию <?=$Subcategory->name?>?
    <br>
    <input type="hidden" name="id" value="<?= $Subcategory->id ?>">
    <input type="submit" class="btn btn-danger" name="delete" value="Удалить">
    <input type="submit" class="btn btn-light" name="cancel" value="Вернуться"><br>
</form>
