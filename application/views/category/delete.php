<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $deleteCategoryTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/category/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить категорию <?=$deletedCategory->name?>?
    <br>
    <input type="hidden" name="id" value="<?= $deletedCategory->id ?>">
    <input type="submit" class="btn btn-danger" name="deleteCategory" value="Удалить">
    <input type="submit" class="btn btn-light"name="cancel" value="Вернуться"><br>
</form>
