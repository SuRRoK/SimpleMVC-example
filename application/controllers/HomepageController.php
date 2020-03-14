<?php
namespace application\controllers;

use application\models\ArticleModel;
use application\models\CategoryModel;
use application\models\SubcategoryModel;
use ItForFree\SimpleMVC\Config;

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
        $contentFirstSymbols = Config::get('core.homepage.firstContentSymbols');
        $homepageNumArticles = Config::get('core.homepage.homepageNumArticles');
        $articles = (new ArticleModel())->getListWithParam($homepageNumArticles, null, false)['results'];
        $categories = CategoryModel::getAllAssoc();
        $subcategories = SubcategoryModel::getAllAssoc();
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('contentFirstSymbols', $contentFirstSymbols);
        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/index.php');

    }
}

