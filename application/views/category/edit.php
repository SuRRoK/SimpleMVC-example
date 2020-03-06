<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $editCategoryTitle ?>
    <span class="small">
        <?= $User->returnIfAllowed('admin/category/delete',
            '<a href=' . $Url::link('admin/category/delete&id=' . $_GET['id'])
            . '>[Удалить]</a>')?>
    </span>
</h2>

<form id="editUser" method="post" action="<?= $Url::link('admin/category/edit&id=' . $_GET['id'])?>">
    <h5>Название категории</h5>
    <input type="text" name="name" class="form-control"  placeholder="Введите название категории" value="<?= $viewCategory->name ?>"><br>
    <h5>Описание категории</h5>
    <textarea name="description" class="form-control"  placeholder="email"><?= $viewCategory->description ?></textarea><br>

    <input type="hidden" name="id" value="<?= $_GET['id']?>">
    <input type="submit" class="btn btn-success" name="saveChanges" value="Сохранить">
    <input type="submit" class="btn btn-danger" name="cancel" value="Назад">
</form>
