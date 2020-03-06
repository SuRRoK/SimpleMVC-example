<?php
namespace application\controllers;

use application\models\CategoryModel;

class HomepageController extends \ItForFree\SimpleMVC\mvc\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";
    
    public $layoutPath = 'main.php';


    /**
     * Выводит на экран страницу "Домашняя страница"
     */
    public function indexAction()
    {
        $cat = new CategoryModel();
        $cat = $cat->getById(11);

        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/index.php');

    }
}

