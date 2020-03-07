<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-subcategories-nav.php');?>

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
    <?php foreach($subcategories as $Subcategory): ?>
    <tr class="pointer" onclick="location='<?php echo Url::link('admin/subcategory/index&id=' . $Subcategory->id) ?>'">
        <td> <?= $Subcategory->id ?> </td>
        <td> <?= $Subcategory->name ?> </td>
        <td>  <?= $Subcategory->description ?> </td>
        <td>  <?= $categories[$Subcategory->categoryId]?> </td>
        <td>  <?= $User->returnIfAllowed('admin/subcategory/edit',
                    '<a href=' . Url::link('admin/subcategory/edit&id=' . $Subcategory->id)
                    . '>[Редактировать]</a>')?></td>
    </tr>
    <?php endforeach; ?>
    
    </tbody>
</table>

<?php else:?>
    <p> Список подкатегорий пуст. </p>
<?php endif; ?>