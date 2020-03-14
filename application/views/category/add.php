<?php include('includes/admin-categories-nav.php'); ?>
<h2><?= $addCategoryTitle ?></h2>

<form id="addUser" method="post" action="<?= \ItForFree\SimpleMVC\Url::link("admin/category/add")?>">

    <div class="form-group">
        <label for="name">Название категории</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Введите название категории">
    </div>
    <div class="form-group">
        <label for="description">Описание категории</label>
        <textarea class="form-control"  name="description" id="description" placeholder="Введите описание категории"></textarea>
    </div>

    <input type="submit" class="btn btn-primary" name="saveNewCategory" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>


