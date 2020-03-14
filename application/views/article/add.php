<?php include('includes/admin-articles-nav.php'); ?>
<h2><?= $title ?></h2>

<?php $currentCategory = '';
//vdie($users);?>
<form id="addArticle" method="post" action="<?= \ItForFree\SimpleMVC\Url::link("admin/article/add")?>">

    <div class="form-group">
        <label for="title">Заголовок статьи</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Введите заголовок статьи">
    </div>
    <div class="form-group">
        <label for="summary">Краткое содержание статьи</label>
        <textarea class="form-control"  name="summary" id="summary" placeholder="Введите краткое содержание статьи"></textarea>
    </div>

    <div class="form-group">
        <label for="content">Содержание статьи</label>
        <textarea class="form-control"  name="content" id="content" placeholder="Введите содержание статьи"></textarea>
    </div>

    <div class="form-group">
        <label for="category">Категория</label>
        <select class="form-control" name="categoryId" id="category">
            <option value="0">Без категории</option>
            <?php foreach ($categories as $categoryId => $categoryName) { ?>
                <option value="<?= $categoryId ?>"><?= $categoryName ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="subcategory">Подкатегория</label>
        <select class="form-control" name="subcategoryId" id="subcategory">
            <option value="0">Без подкатегории</option>
            <noscript>
                <?php foreach ($subcategories as $subcategory) {
                if ($subcategory['categoryName'] !== $currentCategory) {
                if ($currentCategory === '') {
                $currentCategory = $subcategory['categoryName']; ?>
                <optgroup label="<?= $currentCategory ?>">
                    <option value="<?php echo $subcategory['id'] ?>"</option>
                    <?php } else {
                    $currentCategory = $subcategory['categoryName'] ?>
                </optgroup>
                <optgroup label="<?= $currentCategory ?>">
                    <option value="<?= $subcategory['id'] ?>"><?= htmlspecialchars($subcategory['name']) ?></option>
                    <?php }
                    } else { ?>
                        <option value="<?= $subcategory['id'] ?>"><?= htmlspecialchars($subcategory['name']) ?></option>
                    <?php } }?>
            </noscript>
        </select>
    </div>

    <div class="form-group">
        <label for="publicationDate">Дата публикации</label>
        <input type="date" class="form-control" name="publicationDate" id="publicationDate">
    </div>

    <div class="form-group">
        <span>Публикуется</span>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary active">
                <input type="radio" name="isActive" id="yes" value="yes" autocomplete="off" checked> Да
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="isActive" id="no" value="no" autocomplete="off"> Нет
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="authors">Авторство</label>
        <select class="form-control" name="authors[]" multiple size="6">
            <?php foreach ($users as $userId => $userName) { ?>

                <option value="<?= $userId ?>"><?= htmlspecialchars($userName) ?></option>
            <?php } ?>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" name="saveNew" value="Сохранить">
    <input type="submit" class="btn btn-warning" name="cancel" value="Назад">
</form>
<template id="optionNone">
    <option value="0">Без подкатегории</option>
</template>
<template id="optionGroup">
    <optgroup label=""></optgroup>
</template>
<template id="option">
    <option value=""></option>
</template>
<script>
    const subcategories = JSON.parse('<?= json_encode($subcategories) ?>');
</script>
<script src="./JS/subcategories.js"></script>


