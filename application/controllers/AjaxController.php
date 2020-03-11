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
            if(isset($Article->id)) {
                $Article->getArticleAuthors();
                if($Article->authors) {
                    echo implode(', ', $Article->authors);
                } else {
                    echo 'Автор неизвестен';
                }
            } else {
                echo 'Не верный запрос';
            }

        }
    }

    public function contentAction(): void
    {
        if (isset($_GET['articleId'])) {
            $Article = (new ArticleModel)->getById((int)$_GET['articleId']);
            echo isset($Article->id) ? nl2br($Article->content) : '';
        }
        if (isset ($_POST['articleId'])) {
            $Article = (new ArticleModel)->getById((int)$_POST['articleId']);
            echo isset($Article->id) ? json_encode(nl2br($Article->content), JSON_THROW_ON_ERROR, 512) : '';
        }
    }

}

