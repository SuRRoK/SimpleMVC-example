<h2><?= $deleteCategoryTitle ?></h2>

<form method="post" action="<?= \Url::link("category/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить категорию?
    
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
    <input type="submit" name="deleteCategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>

