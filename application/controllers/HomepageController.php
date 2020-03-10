<?php
namespace application\controllers;

use application\models\ArticleModel;
use application\models\CategoryModel;
use application\models\SubcategoryModel;

class HomepageController extends \ItForFree\SimpleMVC\mvc\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = 'Главная страница';
    
    public $layoutPath = 'main.php';

    /**
     * Выводит на экран страницу "Домашняя страница"
     */
    public function indexAction()
    {
        $articles = (new ArticleModel())->getListWithParam()['results'];
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/index.php');

    }
}

