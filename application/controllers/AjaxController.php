<?php
namespace application\controllers;

use application\models\ArticleModel;

/**
 * Можно использовать для обработки ajax-запросов.
 */
class AjaxController extends \ItForFree\SimpleMVC\mvc\Controller 
{
    /**
     * Подгрузка авторов статей
     */
    public function authorsAction(): void
    {
        if (isset($_GET['articleId'])) {
            $Article = (new ArticleModel)->getById((int)$_GET['articleId']);
            $Article->getArticleAuthors();
            if($Article->authors) {
                echo implode(', ', $Article->authors);
            } else {
                echo 'Автор неизвестен';
            }
        }
    }

    public function contentAction(): void
    {
        if (isset($_GET['articleId'])) {
            $Article = (new ArticleModel)->getById((int)$_GET['articleId']);
            echo nl2br($Article->content);
        }
        if (isset ($_POST['articleId'])) {
            //die("Привет)");
            $Article = (new ArticleModel)->getById((int)$_POST['articleId']);
            echo json_encode(nl2br($Article->content), JSON_THROW_ON_ERROR, 512);
        }
    }

}

