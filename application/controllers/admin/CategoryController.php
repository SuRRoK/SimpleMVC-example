<?php
namespace application\controllers\admin;
use \application\models\CategoryModel as Category;
use ItForFree\SimpleMVC\Config;


class CategoryController extends \ItForFree\SimpleMVC\mvc\Controller
{
    
    public $layoutPath = 'admin-main.php';
    
    protected $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => true, 'roles' => ['auth_user'], 'actions' => ['index', 'add']],
    ];
    
    public function indexAction()
    {
        $Url = Config::get('core.url.class');
        $Category = new Category();
        $categoryId = $_GET['id'] ?? null;
        if ($categoryId) {
            $Category = $Category->getById($_GET['id']);
            if (isset($Category->id)) {
                $this->view->addVar('viewCategory', $Category);
                $this->view->render('category/view-item.php');
            } else {
                $this->redirect($Url::link('admin/category/index'));
            }
        } else {
            $categories = $Category->getList()['results'];
            $this->view->addVar('categories', $categories);
            $this->view->render('category/index.php');
        }
    }

    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.url.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewCategory'])) {
                $Category = new Category();
                $Category = $Category->loadFromArray($_POST);
                $Category->insert();
                $this->redirect($Url::link('admin/category/index'));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link('admin/category/index'));
            }
        }
        else {
            $addCategoryTitle = 'Добавление новой категории';
            $this->view->addVar('addCategoryTitle', $addCategoryTitle);
            
            $this->view->render('category/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования категории (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');
        
        if (!empty($_POST)) { // это выполняется нормально.
            
            if (!empty($_POST['saveChanges'] )) {
                $Category = new Category();
                $Category = $Category->loadFromArray($_POST);
                $Category->update();
                $this->redirect($Url::link("admin/category/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/category/index&id=$id"));
            }
        }
        else {
            $Category = new Category();
            $Category = $Category->getById($id);
            $editCategoryTitle = 'Редактирование категории';
            
            $this->view->addVar('viewCategory', $Category);
            $this->view->addVar('editCategoryTitle', $editCategoryTitle);
            
            $this->view->render('category/edit.php');
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
            if (!empty($_POST['deleteCategory'])) {
                $Category = new Category();
                $Category = $Category->loadFromArray($_POST);
                $Category->delete();
                
                $this->redirect($Url::link('admin/category/index'));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/category/edit&id=$id"));
            }
        }
        else {

            $Category = new Category();
            $Category = $Category->getById($id);
            $deleteCategoryTitle = 'Удаление категории';

            $this->view->addVar('deletedCategory', $Category);
            $this->view->addVar('deleteCategoryTitle', $deleteCategoryTitle);
            $this->view->render('category/delete.php');
        }
    }
}
