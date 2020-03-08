<?php include('includes/admin-articles-nav.php'); ?>
<h2><?= $title ?></h2>

<form id="addArticle" method="post" action="<?= \ItForFree\SimpleMVC\Url::link("admin/article/add")?>">

    <div class="form-group">
        <label for="title">Заголовок статьи</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Введите заголовок статьи">
    </div>
    <div class="form-group">
        <label for="summary">Краткое содержание статьи</label>
        <textarea class="form-control"  name="summary" id="summary" placeholder="Введите раткое содержание статьи"></textarea>
    </div>

    <div class="form-group">
        <label for="content">Содержание статьи</label>
        <textarea class="form-control"  name="content" id="content" placeholder="Введите содержание статьи"></textarea>
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" name="categoryId" id="category">
            <?php foreach ($categories as $categoryId => $categoryName) { ?>
                <option value="<?= $categoryId ?>"><?= $categoryName ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="subcategory">Category</label>
        <select class="form-control" name="subcategoryId" id="subcategory">
            <?php foreach ($subcategories as $subcategoryId => $subcategoryName) { ?>
                <option value="<?= $subcategoryId ?>"><?= $subcategoryName ?></option>
            <?php } ?>
        </select>
    </div>
    <input type="submit" class="btn btn-primary" name="saveNew" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>


