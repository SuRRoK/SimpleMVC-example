<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-articles-nav.php'); /*vpre($articles);*/ ?>

<h2>Список статей</h2>

<?php if (!empty($articles)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Заголовок</th>
      <th scope="col">Категория</th>
      <th scope="col">Подкатегория</th>
      <th scope="col">Дата публикации</th>
      <th scope="col">Статус</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($articles as $Article): ?>
    <tr class="pointer" onclick="location='<?php echo Url::link('admin/article/index&id=' . $Article->id) ?>'">
        <td> <?= $Article->id ?> </td>
        <td> <?= $Article->title ?> </td>

        <td> <?= $categories[$Article->categoryId] ?? 'Без категории'?> </td>
        <td> <?= $subcategories[$Article->subcategoryId] ?? 'Без подкатегории'?> </td>
        <td> <?= $Article->publicationDate ?> </td>
        <td> <?= $Article->isActive ? 'Активна' : 'Скрыта'?> </td>
        <td> <?= $User->returnIfAllowed('admin/article/edit',
                    '<a href=' . Url::link('admin/article/edit&id=' . $Article->id)
                    . '>[Редактировать]</a>')?></td>
    </tr>
    <?php endforeach; ?>
    
    </tbody>
</table>

<?php else:?>
    <p> Список статей пуст. </p>
<?php endif; ?>