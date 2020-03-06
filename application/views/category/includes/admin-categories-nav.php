<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');


//vpre($User->explainAccess("admin/category/index"));
?>

<ul class="nav">
    
    <?php  if ($User->isAllowed("admin/category/index")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= Url::link("admin/category/index") ?>">Список</a>
    </li>
    <?php endif; ?>
    
    <?php  if ($User->isAllowed("admin/category/add")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= Url::link("admin/category/add") ?>"> + Добавить категорию</a>
    </li>
    <?php endif; ?>  
</ul>