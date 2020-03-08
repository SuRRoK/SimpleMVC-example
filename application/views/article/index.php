<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-articles-nav.php');?>

<h2>Список подкатегорий</h2>

<?php if (!empty($subcategories)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Category</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($subcategories as $Article): ?>
    <tr class="pointer" onclick="location='<?php echo Url::link('admin/article/index&id=' . $Article->id) ?>'">
        <td> <?= $Article->id ?> </td>
        <td> <?= $Article->name ?> </td>
        <td>  <?= $Article->description ?> </td>
        <td>  <?= $categories[$Article->categoryId]?> </td>
        <td>  <?= $User->returnIfAllowed('admin/article/edit',
                    '<a href=' . Url::link('admin/article/edit&id=' . $Article->id)
                    . '>[Редактировать]</a>')?></td>
    </tr>
    <?php endforeach; ?>
    
    </tbody>
</table>

<?php else:?>
    <p> Список подкатегорий пуст. </p>
<?php endif; ?>