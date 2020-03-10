<?php
namespace application\controllers;

use application\models\ArticleModel;
use application\models\CategoryModel;
use application\models\SubcategoryModel;
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Url;


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
        $categoryId = null;
        if (isset( $_GET['id'] )) {
            $categoryFilter = ['type' => 'categoryId', 'value' => (int)$_GET['id']];
        } else {
            $categoryFilter = null;
        }

        $articles = (new ArticleModel())->getListWithParam(100000, $categoryFilter, false)['results'];
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $lead = ($_GET['id'] === 'none' || !$categories[$_GET['id']]) ? '...  статьям без катеории' : '...  статьям категории ' . $categories[$_GET['id']];
        $this->view->addVar('lead', $lead);
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('homepageTitle', $this->homepageTitle);
        $this->view->render('archive/index.php');

    }

    public function subcategoryAction()
    {
        $subcategoryId = null;
        if (isset( $_GET['id'] )) {
            $categoryFilter = ['type' => 'subcategoryId', 'value' => $_GET['id']];
        } else {
            $categoryFilter = null;
        }

        $articles = (new ArticleModel())->getListWithParam(100000, $categoryFilter, false)['results'];
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $lead = ($_GET['id'] === 'none' || !$subcategories[$_GET['id']]) ? '...  статьям без подкатеории' : '...  статьям подкатегории ' . $subcategories[$_GET['id']];
        $this->view->addVar('lead', $lead);
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

        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('homepageTitle', $this->homepageTitle);

        if (isset( $_GET['id'])) {
            $Article = (new ArticleModel())->getById($_GET['id']);
            $Article->getArticleAuthors();
            $Article->publicationDate = strtotime($Article->publicationDate);
            if ($Article->id) {
                $this->view->addVar('Article', $Article);
                $lead = '';
                $this->view->addVar('lead', $lead);
                $this->view->render('archive/article.php');
            }
        } else {
            header('Location: ' . URL::link('archive/index'));
        }
    }
}

