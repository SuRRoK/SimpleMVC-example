<?php include('includes/admin-subcategories-nav.php'); ?>
<h2><?= $title ?></h2>

<form id="addUser" method="post" action="<?= \ItForFree\SimpleMVC\Url::link("admin/subcategory/add")?>">

    <div class="form-group">
        <label for="name">Название подкатегории</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Введите название подкатегории">
    </div>
    <div class="form-group">
        <label for="description">Описание подкатегории</label>
        <textarea class="form-control"  name="description" id="description" placeholder="Введите описание подкатегории"></textarea>
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" name="categoryId" id="category">
            <?php foreach ($categories as $categoryId => $categoryName) { ?>
                <option value="<?= $categoryId ?>"><?= $categoryName ?></option>
            <?php } ?>
        </select>
    </div>
    <input type="submit" class="btn btn-primary" name="saveNew" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>


