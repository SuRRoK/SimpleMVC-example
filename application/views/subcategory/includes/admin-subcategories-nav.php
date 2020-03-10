<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;

$User = Config::getObject('core.user.class');


//vpre($User->explainAccess("admin/subcategory/index"));
?>

<ul class="nav">
    
    <?php  if ($User->isAllowed("admin/subcategory/index")): ?>
    <li class="nav-item ">
        <a class="btn btn-light m-2" href="<?= Url::link("admin/subcategory/index") ?>">Список</a>
    </li>
    <?php endif; ?>
    
    <?php  if ($User->isAllowed("admin/subcategory/add")): ?>
    <li class="nav-item ">
        <a class="btn btn-success m-2" href="<?= Url::link("admin/subcategory/add") ?>"> + Добавить подкатегорию</a>
    </li>
    <?php endif; ?>  
</ul>