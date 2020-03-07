<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $title ?>
    <span class="small">
        <?= $User->returnIfAllowed('admin/subcategory/delete',
            '<a href=' . $Url::link('admin/subcategory/delete&id=' . $_GET['id'])
            . '>[Удалить]</a>')?>
    </span>
</h2>

<form id="editUser" method="post" action="<?= $Url::link('admin/subcategory/edit&id=' . $_GET['id'])?>">
    <h5>Название категории</h5>
    <input type="text" name="name" class="form-control"  placeholder="Введите название категории" value="<?= $Subcategory->name ?>"><br>
    <h5>Описание категории</h5>
    <textarea name="description" class="form-control"  placeholder="email"><?= $Subcategory->description ?></textarea><br>

    <input type="hidden" name="id" value="<?= $_GET['id']?>">
    <input type="submit" class="btn btn-success" name="saveChanges" value="Сохранить">
    <input type="submit" class="btn btn-danger" name="cancel" value="Назад">
</form>
