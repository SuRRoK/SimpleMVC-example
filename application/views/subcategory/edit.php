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
    <div class="form-group">
        <label for="name">Название подкатегории</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Введите название подкатегории" value="<?= $Subcategory->name ?>">
    </div>
    <div class="form-group">
        <label for="description">Описание подкатегории</label>
        <textarea class="form-control"  name="description" id="description" placeholder="Введите описание подкатегории"><?= $Subcategory->description ?></textarea>
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" name="categoryId" id="category">
            <?php foreach ($categories as $categoryId => $categoryName) { ?>
                <option value="<?= $categoryId ?>" <?php if ($categoryId == $Subcategory->categoryId) { print ' selected '; } ?>><?= $categoryName ?></option>
            <?php } ?>
        </select>
    </div>
    <input type="hidden" name="id" value="<?= $_GET['id']?>">
    <input type="submit" class="btn btn-success" name="saveChanges" value="Сохранить">
    <input type="submit" class="btn btn-danger" name="cancel" value="Назад">
</form>
