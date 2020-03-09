<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $Article->title ?>

</h2>

<div class="card" style="width: 30%;">
    <div class="card-body">
        <h5 class="card-title">Категория: <span class="card-text small"><?= $categories[$Article->categoryId] ?? 'Без категории'?></span></h5>
        <hr>
        <h5 class="card-title">Подкатегория: <span class="card-text small"><?= $subcategories[$Article->subcategoryId] ?? 'Без подкатегории'?></span></h5>
        <hr>
        <h5 class="card-title">Дата добавления: <span class="card-text small"><?= $Article->publicationDate ?></span></h5>
    </div>
    <div class="card-body">
        <span class="btn btn-warning"><?= $User->returnIfAllowed("admin/article/edit",
            '<a href=' . Url::link('admin/article/edit&id=' . $Article->id)
            . '>[Редактировать]</a>')?>
        </span>
        <span class="btn btn-danger">
        <?= $User->returnIfAllowed('admin/article/delete',
            '<a class="text-black-50" href=' . Url::link('admin/article/delete&id=' . $Article->id)
            . '>[Удалить]</a>')?>
        </span>
    </div>
</div>
<br>
<p><?= $Article->content ?></p>
