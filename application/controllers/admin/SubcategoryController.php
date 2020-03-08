<?php
namespace application\controllers\admin;
use application\models\CategoryModel;
use \application\models\SubcategoryModel as Subcategory;
use ItForFree\SimpleMVC\Config;

/**
 *
 */
class SubcategoryController extends \ItForFree\SimpleMVC\mvc\Controller
{
    
    public $layoutPath = 'admin-main.php';

    protected $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
        ['allow' => true, 'roles' => ['admin']],
        ['allow' => true, 'roles' => ['auth_user'], 'actions' => ['index']],
    ];

    public function indexAction()
    {
        $Subcategory = new Subcategory();
        $subcategoryId = $_GET['id'] ?? null;

        if ($subcategoryId) {
            $Subcategory = $Subcategory->getById($_GET['id']);
            $this->view->addVar('Subcategory', $Subcategory);
            $this->view->render('subcategory/view-item.php');
        } else { // выводим полный список

            $subcategories = $Subcategory->getList()['results'];
            $categories = CategoryModel::getCategoriesAssoc();
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->render('subcategory/index.php');
        }
    }

    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.url.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNew'])) {
                $Subcategory = new Subcategory();
                $Subcategory = $Subcategory->loadFromArray($_POST);
                $Subcategory->insert();
                $this->redirect($Url::link('admin/subcategory/index'));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link('admin/subcategory/index'));
            }
        }
        else {
            $title = 'Добавление новой подкатегории';

            $categories = CategoryModel::getCategoriesAssoc();
            $this->view->addVar('categories', $categories);
            $this->view->addVar('title', $title);
            $this->view->render('subcategory/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования подкатегории (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');
        
        if (!empty($_POST)) { // это выполняется нормально.
            
            if (!empty($_POST['saveChanges'] )) {
                $Subcategory = new Subcategory();
                $Subcategory = $Subcategory->loadFromArray($_POST);
                $Subcategory->update();
                $this->redirect($Url::link("admin/subcategory/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategory/index&id=$id"));
            }
        }
        else {
            $Subcategory = new Subcategory();
            $Subcategory = $Subcategory->getById($id);
            $title = 'Редактирование подкатегории';
            $categories = CategoryModel::getCategoriesAssoc();
            $this->view->addVar('categories', $categories);
            $this->view->addVar('Subcategory', $Subcategory);
            $this->view->addVar('title', $title);
            
            $this->view->render('subcategory/edit.php');
        }
        
    }
    
    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['delete'])) {
                $Subcategory = new Subcategory();
                $newSubcategory = $Subcategory->loadFromArray($_POST);
                $newSubcategory->delete();
                
                $this->redirect($Url::link('admin/subcategory/index'));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategory/edit&id=$id"));
            }
        }
        else {

            $Subcategory = new Subcategory();
            $Subcategory = $Subcategory->getById($id);
            $title = 'Удаление подкатегории';

            $this->view->addVar('Subcategory', $Subcategory);
            $this->view->addVar('title', $title);
            $this->view->render('subcategory/delete.php');
        }
    }
}
