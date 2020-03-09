<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
$User = Config::getObject('core.user.class');

$currentCategory = '';
?>


<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $title ?>
    <span class="badge badge-danger">
        <?= $User->returnIfAllowed('admin/article/delete',
            '<a class="text-black-50" href=' . $Url::link('admin/article/delete&id=' . $Article->id)
            . '>[Удалить]</a>')?>
    </span>
</h2>

<form id="editArticle" method="post" action="<?= $Url::link('admin/article/edit&id=' . $_GET['id'])?>">
    <input type="hidden" name="id" value="<?= $Article->id ?>">

    <div class="form-group">
        <label for="title">Заголовок статьи</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Введите заголовок статьи" value="<?= $Article->title?>">
    </div>
    <div class="form-group">
        <label for="summary">Краткое содержание статьи</label>
        <textarea class="form-control"  name="summary" id="summary" placeholder="Введите краткое содержание статьи"><?= $Article->summary?></textarea>
    </div>

    <div class="form-group">
        <label for="content">Содержание статьи</label>
        <textarea class="form-control"  name="content" id="content" placeholder="Введите содержание статьи"><?= $Article->content?></textarea>
    </div>

    <div class="form-group">
        <label for="category">Категория</label>
        <select class="form-control" name="categoryId" id="category">
            <option value="0" <?= !$Article->categoryId ? ' selected' : '' ?>>Без категории</option>
            <?php foreach ($categories as $categoryId => $categoryName) { ?>
                <option value="<?= $categoryId ?>" <?= $categoryId == $Article->categoryId ? ' selected' : ''?>><?= $categoryName ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="subcategory">Подкатегория</label>
        <select class="form-control" name="subcategoryId" id="subcategory">
            <option value="0" <?= !$Article->subcategoryId ? ' selected' : '' ?>>Без подкатегории</option>
            <noscript>
                <?php foreach ($subcategories as $subcategory) {
                if ($subcategory['categoryName'] !== $currentCategory) {
                if ($currentCategory === '') {
                $currentCategory = $subcategory['categoryName']; ?>
                <optgroup label="<?= $currentCategory ?>">
                    <option value="<?php echo $subcategory['id'] ?>"<?= ($subcategory['id'] === $Article->subcategoryId) ? ' selected' : '' ?>><?php echo htmlspecialchars($subcategory['name']) ?></option>
                    <?php } else {
                    $currentCategory = $subcategory['categoryName'] ?>
                </optgroup>
                <optgroup label="<?= $currentCategory ?>">
                    <option value="<?= $subcategory['id'] ?>"<?= ($subcategory['id'] === $Article->subcategoryId) ? ' selected' : '' ?>><?= htmlspecialchars($subcategory['name']) ?></option>
                    <?php }
                    } else { ?>
                        <option value="<?= $subcategory['id'] ?>"<?= ($subcategory['id'] === $Article->subcategoryId) ? ' selected' : '' ?>><?= htmlspecialchars($subcategory['name']) ?></option>
                    <?php } }?>
            </noscript>
        </select>
    </div>

    <div class="form-group">
        <label for="publicationDate">Дата публикации</label>
        <input type="date"
               class="form-control"
               name="publicationDate"
               id="publicationDate"
               maxlength="10"
               placeholder="ГГГГ-ММ-ДД"
               required
               value="<?php echo $Article->publicationDate ? date('Y-m-d', $Article->publicationDate) : '' ?>"/>
    </div>
    <div class="form-group">
        <span>Публикуется</span>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary <?= $Article->isActive ? 'active' : ''?>">
                <input type="radio" name="isActive" id="yes" value="yes" autocomplete="off" <?= $Article->isActive ? 'checked' : ''?>> Да
            </label>
            <label class="btn btn-primary <?= $Article->isActive ? '' : 'active'?>">
                <input type="radio" name="isActive" id="no" value="no" autocomplete="off" <?= $Article->isActive ? '' : 'checked'?>> Нет
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="authors">Авторство</label>
        <select class="form-control" name="authors[]" multiple size="6">
            <?php foreach ($users as $userId => $userName) { ?>
                <option value="<?= $userId ?>"<?php
                if ($Article->authors && in_array($userName, $Article->authors, true)) {
                    print ' selected ';
                }?>><?= htmlspecialchars($userName) ?></option>
            <?php } ?>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" name="saveChanges" value="Сохранить">
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
    const articleSubcategory = JSON.parse('<?= json_encode($Article->subcategoryId) ?>');
</script>
<script src="./JS/subcategories.js"></script>
