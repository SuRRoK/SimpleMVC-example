<?php
namespace application\controllers\admin;
use \application\models\CategoryModel as Category;
use ItForFree\SimpleMVC\Config;

/**
 *
 */
class CategoryController extends \ItForFree\SimpleMVC\mvc\Controller
{
    
    public $layoutPath = 'admin-main.php';
    
    protected $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => true, 'roles' => ['auth_user'], 'actions' => ['index', 'add']],
    ];
    
    public function indexAction()
    {
        $Category = new Category();
        $categoryId = $_GET['id'] ?? null;
        
        if ($categoryId) {
            $viewCategory = $Category->getById($_GET['id']);
            $this->view->addVar('viewCategory', $viewCategory);
            $this->view->render('category/view-item.php');
        } else { // выводим полный список
            
            $categories = $Category->getList()['results'];
//            vdie($categories);
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
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->insert();
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
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->update();
                $this->redirect($Url::link("admin/category/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/category/index&id=$id"));
            }
        }
        else {
            $Category = new Category();
            $viewCategory = $Category->getById($id);
            $editCategoryTitle = 'Редактирование категории';
            
            $this->view->addVar('viewCategory', $viewCategory);
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
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->delete();
                
                $this->redirect($Url::link('admin/category/index'));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/category/edit&id=$id"));
            }
        }
        else {

            $Category = new Category();
            $deletedCategory = $Category->getById($id);
            $deleteCategoryTitle = 'Удаление категории';

            $this->view->addVar('deletedCategory', $deletedCategory);
            $this->view->addVar('deleteCategoryTitle', $deleteCategoryTitle);
            $this->view->render('category/delete.php');
        }
    }
}
