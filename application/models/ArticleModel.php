<?php

namespace application\models;


use ItForFree\SimpleMVC\mvc\Model;
use PDO;

/**
 * Description of Article
 *
 * @author surrok
 */
class ArticleModel extends Model
{
    /**
     * Имя таблицы со статьями
     */
    public $tableName = 'articles';

    /**
     * @var string Критерий сортировки строк таблицы
     */
    public $orderBy = '$publicationDate';

    /**
     * @var int Дата первой публикации статьи
     */
    public $publicationDate = null;

    /**
     * @var string Полное название статьи
     */
    public $title = null;

    /**
     * @var int ID категории статьи
     */
    public $categoryId = null;

    /**
     * @var string Краткое описание статьи
     */
    public $summary = null;

    /**
     * @var string HTML содержание статьи
     */
    public $content = null;

    /**
     * @var int Статус статьи
     * is_active = 1 Отображается
     * is_active = 0 Скрыта
     */
    public $isActive = null;

    /**
     * @var int ID подкатегории статьи
     */
    public $subcategoryId = null;

    /**
     * @var array ассоциативный массив авторов статьи id->name
     */
    public $authors = null;

    /**
     * Вставка новой записи в БД
     */
    public function insert()
    {
        // Вставляем статью
        $sql = "INSERT INTO $this->tableName ( publicationDate, categoryId, subcategoryId, title, summary, content, is_active)" .
            "VALUES ( FROM_UNIXTIME(:publicationDate), :categoryId, :subcategoryId, :title, :summary, :content, :isActive )";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":isActive", $this->isActive, PDO::PARAM_INT);
        $st->execute();

        $this->id = $this->pdo->lastInsertId();


        $authors = '';
        foreach ($this->authors as $author) {
            $authors .= "($this->id,$author),";
        }
        $authors = mb_substr($authors, 0, -1);
        $sql = "INSERT INTO articles_users (article_id, user_id) VALUES $authors";
        $st = $this->pdo->query($sql);
        $this->insertAuthors($this->pdo, $this->id, $this->authors);
        /*        $sql = "INSERT INTO articles_users (article_id, user_id) VALUES :authors";
                $st = $conn->prepare($sql);
                $st->bindValue(":authors", $authors);
                $st->execute();*/
    }

    /**
     * Обновляем текущий объект статьи в базе данных
     */
    public function update()
    {
        // Обновляем статью
        $sql = "UPDATE $this->tableName SET publicationDate=FROM_UNIXTIME(:publicationDate),"
            . " categoryId=:categoryId, subcategoryId=:subcategoryId, title=:title, summary=:summary,"
            . " content=:content, is_active=:isActive WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":categoryId", $this->categoryId, PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":isActive", $this->isActive, PDO::PARAM_INT);
        $st->execute();
        $this->deleteAuthors($this->pdo, $this->id);
        $this->insertAuthors($this->pdo, $this->id, $this->authors);
    }

    private function insertAuthors($connection, $articleId, $authors)
    {
        foreach ($authors as $author) {
            $sql = "INSERT INTO articles_users (article_id, user_id) VALUES (:articleId, :authorId)";
            $st = $connection->prepare($sql);
            $st->bindValue(":authorId", $author, PDO::PARAM_INT);
            $st->bindValue(":articleId", $articleId, PDO::PARAM_INT);
            $st->execute();
        }
    }

    private function deleteAuthors($connection, $articleId)
    {
        $sql = "DELETE FROM articles_users WHERE article_id = :id";
        $st = $connection->prepare($sql);
        $st->bindValue(":id", $articleId, PDO::PARAM_INT);
        $st->execute();
    }

}
