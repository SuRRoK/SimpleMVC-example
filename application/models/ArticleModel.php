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
    public $orderBy = 'id';

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

    public function loadFromArray($arr)
    {
        $newInstance = new static($arr);

        // Обрабатываем галочку статуса статьи
        $newInstance->isActive = isset($arr['isActive']) && $arr['isActive'] === 'yes';
        // Обрабатываем ID подкатегории
        if (isset($arr['subcategoryId']) && $arr['subcategoryId'] !== '0') {
            $newInstance->subcategoryId = (int)$arr['subcategoryId'];
        } else {
            $newInstance->subcategoryId = null;
        }
        // Обрабатываем дату публикации
        if (isset($arr['publicationDate'])) {
            $newInstance->unixDate();
        }
        return $newInstance;
    }

    public function unixDate(): void
    {
        $publicationDate = explode('-', $this->publicationDate);

        if (count($publicationDate) === 3) {
            [$y, $m, $d] = $publicationDate;
            $this->publicationDate = mktime(0, 0, 0, $m, $d, $y);
        }
    }

    /**
     * Вставка новой записи в БД
     */
    public function insert()
    {
        // Вставляем статью
        $sql = "INSERT INTO $this->tableName ( publicationDate, categoryId, subcategoryId, title, summary, content, isActive)" .
            'VALUES ( FROM_UNIXTIME(:publicationDate), :categoryId, :subcategoryId, :title, :summary, :content, :isActive )';
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

        if ($this->authors) {
            $this->insertAuthors();
//            $authors = '';
//            foreach ($this->authors as $author) {
//                $authors .= "($this->id,$author),";
//            }
//            $authors = mb_substr($authors, 0, -1);
//            $sql = "INSERT INTO articles_users (article_id, user_id) VALUES $authors";
//            $st = $this->pdo->query($sql);

            /*        $sql = "INSERT INTO articles_users (article_id, user_id) VALUES :authors";
                    $st = $this->pdo->prepare($sql);
                    $st->bindValue(":authors", $authors);
                    $st->execute();*/
        }
    }

    /**
     * Обновляем текущий объект статьи в базе данных
     */
    public function update()
    {
        // Обновляем статью
        $sql = "UPDATE $this->tableName SET publicationDate=FROM_UNIXTIME(:publicationDate),"
            . ' categoryId=:categoryId, subcategoryId=:subcategoryId, title=:title, summary=:summary,'
            . ' content=:content, isActive=:isActive WHERE id = :id';
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

        $this->deleteAuthors();

        if ($this->authors) {
            $this->insertAuthors();
        }
    }

    private function insertAuthors()
    {
        foreach ($this->authors as $author) {
            $sql = 'INSERT INTO articles_users (article_id, user_id) VALUES (:articleId, :authorId)';
            $st = $this->pdo->prepare($sql);
            $st->bindValue(':authorId', $author, PDO::PARAM_INT);
            $st->bindValue(':articleId', $this->id, PDO::PARAM_INT);
            $st->execute();
        }
    }

    private function deleteAuthors()
    {
        $sql = 'DELETE FROM articles_users WHERE article_id = :id';
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':id', $this->id, PDO::PARAM_INT);
        $st->execute();
    }

    public function getArticleAuthors()
    {
        // Обновляем статью
        $sql = 'SELECT user_id, login FROM articles_users' .
            ' JOIN users ON user_id = users.id WHERE article_id = :id';
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $this->authors = $st->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
     * Возвращает все (или диапазон) объекты Article из базы данных
     *
     * @param int $numRows Количество возвращаемых строк (по умолчанию = 1000000)
     * @param array $categoryId Вернуть статьи только из категории или подкатегории с указанным ID
     * @param bool $allArticles Возврат всех, либо только активных статей
     * @param string $order Столбец, по которому выполняется сортировка статей (по умолчанию = "publicationDate DESC")
     * @return array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
     */
    public function getListWithParam($numRows = 1000000,
                                   $categoryId = [], $allArticles = true, $order = 'publicationDate DESC')
    {
        $categoryType = $categoryId['type'] ?? false;
        $categoryValue = $categoryId['value'] ?? '';

        $categoryClause = $categoryType ? "$categoryType = :$categoryType" : '';
        if ($categoryType === 'subcategoryId' && $categoryValue === 'none') {
            $categoryClause = 'subcategoryId IS NULL';
        }
        $activeClause = !$allArticles ? 'isActive = 1' : '';
        $filter = '';
        if ($categoryClause && $activeClause) {
            $filter = "WHERE $categoryClause AND $activeClause";
        } elseif ($categoryClause || $activeClause) {
            $filter = "WHERE $categoryClause $activeClause";
        }
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) 
                AS publicationDate
                FROM articles $filter
                ORDER BY  $order  LIMIT :numRows";

        $st = $this->pdo->prepare($sql);

//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $st->bindValue(':numRows', $numRows, PDO::PARAM_INT);

        if (($categoryType && $categoryValue !== 'none')) {
            $st->bindValue(":$categoryType", $categoryValue, PDO::PARAM_INT);
        }

        $st->execute(); // выполняем запрос к базе данных

//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $list = array();

        while ($row = $st->fetch()) {
            $article = new self($row);
            $list[] = $article;
        }

        // Получаем общее количество статей, которые соответствуют критерию
        $sql = 'SELECT FOUND_ROWS() AS totalRows';
        $totalRows = $this->pdo->query($sql)->fetch();

        $sql = 'SELECT article_id, user_id, login FROM articles_users' .
            ' JOIN users ON user_id = users.id ORDER BY article_id';
        $st = $this->pdo->query($sql);

        $authors = [];
        while ($author = $st->fetch(PDO::FETCH_ASSOC)) {
            $authors[$author['article_id']][$author['user_id']] = $author['login'];
        }
        $this->pdo = null;

        foreach ($list as $article) {
            if (isset($authors[$article->id])) {
                $article->authors = $authors[$article->id];
            }
        }

        return [
            'results' => $list,
            'totalRows' => $totalRows[0]
        ];
    }
}
