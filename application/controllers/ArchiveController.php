<?php
namespace application\controllers;

use application\models\ArticleModel;
use application\models\CategoryModel;
use application\models\SubcategoryModel;
use ItForFree\SimpleMVC\Config;


class ArchiveController extends \ItForFree\SimpleMVC\mvc\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = 'Вся информация по...';
    
    public $layoutPath = 'main.php';

    /**
     * Выводит на экран страницу "Страницу со всем содержимым"
     */
    public function indexAction()
    {
        $articles = (new ArticleModel())->getListWithParam(100000, null, false)['results'];
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $lead = '...всем статьям';
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('homepageTitle', $this->homepageTitle);
        $this->view->addVar('lead', $lead);
        $this->view->render('archive/index.php');

    }

    public function categoryAction()
    {
        if (isset($_GET['id'])) {
            $Category = (new CategoryModel())->getById($_GET['id']);
            if (isset($Category->id)) {
                $categoryFilter = ['type' => 'categoryId', 'value' => $_GET['id']];
                $description = $Category->description;
            } else {
                $categoryFilter = null;
                $description = null;
            }
        }

        $articles = (new ArticleModel())->getListWithParam(100000, $categoryFilter, false)['results'];
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $lead = ($_GET['id'] === 'none' || !$categoryFilter || !$categories[$_GET['id']]) ? '...  статьям без катеории' : '...  статьям категории ' . $categories[$_GET['id']];
        $this->view->addVar('lead', $lead);
        $this->view->addVar('description', $description);
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('homepageTitle', $this->homepageTitle);
        $this->view->render('archive/index.php');

    }

    public function subcategoryAction()
    {
        if (isset($_GET['id'])) {
            if ($_GET['id'] === 'none') {
                $categoryFilter = ['type' => 'subcategoryId', 'value' => $_GET['id']];
                $description = null;
            } else {
                $Subcategory = (new SubcategoryModel())->getById($_GET['id']);
                if (isset($Subcategory->id)) {
                    $categoryFilter = ['type' => 'subcategoryId', 'value' => $_GET['id']];
                    $description = $Subcategory->description;
                } else {
                    $categoryFilter = null;
                    $description = null;
                }
            }
        }

        $articles = (new ArticleModel())->getListWithParam(100000, $categoryFilter, false)['results'];
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $lead = ($_GET['id'] === 'none' || !$categoryFilter || !$subcategories[$_GET['id']]) ? '...  статьям без подкатеории' : '...  статьям подкатегории ' . $subcategories[$_GET['id']];
        $this->view->addVar('lead', $lead);
        $this->view->addVar('description', $description);
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('homepageTitle', $this->homepageTitle);
        $this->view->render('archive/index.php');
    }

    public function articleAction()
    {
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $Url = Config::get('core.url.class');
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('homepageTitle', $this->homepageTitle);

        if (isset( $_GET['id'])) {
            $Article = (new ArticleModel())->getById($_GET['id']);

            if (isset($Article->id)) {
                $Article->getArticleAuthors();
                $Article->publicationDate = strtotime($Article->publicationDate);
                $this->view->addVar('Article', $Article);
                $lead = '';
                $this->view->addVar('lead', $lead);
                $this->view->render('archive/article.php');
            } else {
                $this->redirect($Url::link('archive/index'));
            }
        }
    }
}

