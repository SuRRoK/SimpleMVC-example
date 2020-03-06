<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.url.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-users-nav.php'); ?>
<?php //vdie($viewAdminusers);?>

<h2><?= $editAdminusersTitle ?>
    <span class="small">
        <?= $User->returnIfAllowed("admin/adminusers/delete", 
            "<a href=" . $Url::link("admin/adminusers/delete&id=" . $_GET['id']) 
            . ">[Удалить]</a>");?>
    </span>
</h2>

<form id="editUser" method="post" action="<?= $Url::link("admin/adminusers/edit&id=" . $_GET['id'])?>">
    <h5>Введите имя пользователя</h5>
    <input type="text" name="login" class="form-control"  placeholder="Логин пользователя" value="<?= $viewAdminusers->login ?>"><br>
    <h5>Введите пароль</h5>
    <input type="text" name="pass" class="form-control"  placeholder="Новый пароль" value=""><br>
    <h5>Введите e-mail</h5>
    <input type="text" name="email" class="form-control"  placeholder="email" value="<?= $viewAdminusers->email ?>"><br>
    <h5 >Права доступа</h5>
    <select name="role" id="role" class="form-control">
        <option value="admin" <?php if ($viewAdminusers->role === 'admin') echo ' selected'?>>Администратор</option>
        <option value="auth_user" <?php if ($viewAdminusers->role === 'auth_user') echo ' selected'?>>Зарегистрированный пользователь</option>
    </select>
    <br>
    <input type="hidden" name="id" value="<?= $_GET['id']?>">
    <input type="submit" class="btn btn-success" name="saveChanges" value="Сохранить">
    <input type="submit" class="btn btn-danger" name="cancel" value="Назад">
</form>
