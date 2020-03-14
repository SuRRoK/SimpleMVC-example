<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $Article->title ?>

</h2>

<div class="card" style="width: 35%; min-width: 320px">
    <div class="card-body">
        <h5 class="card-title">Категория: <span class="card-text small"><?= $categories[$Article->categoryId] ?? 'Без категории'?></span></h5>
        <hr>
        <h5 class="card-title">Подкатегория: <span class="card-text small"><?= $subcategories[$Article->subcategoryId] ?? 'Без подкатегории'?></span></h5>
        <hr>
        <h5 class="card-title">Дата добавления: <span class="card-text small"><?= $Article->publicationDate ?></span></h5>
    </div>
    <div class="card-body">
        <?= $User->returnIfAllowed("admin/article/edit",
            '<span class="btn btn-warning">
                <a href=' . Url::link('admin/article/edit&id=' . $Article->id)
            . '>[Редактировать]</a></span>')?>


        <?= $User->returnIfAllowed('admin/article/delete',
            '<span class="btn btn-danger">
                <a class="text-black-50" href=' . Url::link('admin/article/delete&id=' . $Article->id)
            . '>[Удалить]</a></span>')?>

    </div>
    <div class="card-body">
        <?php if ($Article->authors) {?>
        <h5 class="card-title">Автор<?= count($Article->authors) > 1 ? 'ы' : '' ?>: <span class="card-text small"><?= implode(', ', $Article->authors)?></span></h5>
        <?php } else {echo 'Автор не указан';}?>
    </div>
</div>
<br>
<div class="card" style="width: 100%; min-width: 320px; margin-bottom: 80px">
<div class="card-body">
<?= nl2br($Article->content) ?>
</div>
</div>
