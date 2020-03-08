<?php
namespace application\controllers\admin;
use application\models\ArticleModel as Article;
use application\models\CategoryModel;
use application\models\SubcategoryModel;
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\mvc\Controller;

/**
 *
 */
class ArticleController extends Controller
{

    public $layoutPath = 'admin-main.php';

    protected $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
        ['allow' => true, 'roles' => ['admin']],
        ['allow' => true, 'roles' => ['auth_user'], 'actions' => ['index']],
    ];

    /**
     *
     */
    public function indexAction(): void
    {
        $Article = new Article();
        $articleId = $_GET['id'] ?? null;

        if ($articleId) {
            $Article = $Article->getById($_GET['id']);
            $this->view->addVar('Article', $Article);
            $this->view->render('article/view-item.php');
        } else { // выводим полный список

            $articles = $Article->getList()['results'];
            $categories = CategoryModel::getCategoriesAssoc();
            $subcategories = SubcategoryModel::getSubcategoriesAssoc();
            $this->view->addVar('articles', $articles);
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->render('article/index.php');
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
                $Article = new Article();
                $Article = $Article->loadFromArray($_POST);
                $Article->insert();
                $this->redirect($Url::link('admin/article/index'));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link('admin/article/index'));
            }
        }
        else {
            $title = 'Добавление новой статьи';

            $categories = CategoryModel::getCategoriesAssoc();
            $subcategories = SubcategoryModel::getSubcategoriesAssoc();
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('title', $title);
            $this->view->render('article/add.php');
        }
    }

    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.url.class');

        if (!empty($_POST)) { // это выполняется нормально.

            if (!empty($_POST['saveChanges'] )) {
                $Article = new Article();
                $Article = $Article->loadFromArray($_POST);
                $Article->update();
                $this->redirect($Url::link("admin/article/index&id=$id"));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/article/index&id=$id"));
            }
        }
        else {
            $Article = new Article();
            $Article = $Article->getById($id);
            $title = 'Редактирование статьи';
            $categories = CategoryModel::getCategoriesAssoc();
            $subcategories = SubcategoryModel::getSubcategoriesAssoc();
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('Article', $Article);
            $this->view->addVar('title', $title);

            $this->view->render('article/edit.php');
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
                $Article = new Article();
                $newArticle = $Article->loadFromArray($_POST);
                $newArticle->delete();
                $this->redirect($Url::link('admin/article/index'));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/article/edit&id=$id"));
            }
        }
        else {
            $Article = new Article();
            $Article = $Article->getById($id);
            $title = 'Удаление статьи';
            $this->view->addVar('Article', $Article);
            $this->view->addVar('title', $title);
            $this->view->render('article/delete.php');
        }
    }
}
