<?php

namespace application\models;

use ItForFree\SimpleMVC\mvc\Model;

/**
 * Description of Category
 *
 * @author surrok
 */
class CategoryModel extends Model
{
    /**
     * Имя таблицы с категориями
     */
    public $tableName = 'categories';

    /**
     * @var string Критерий сортировки строк таблицы
     */
    public $orderBy = 'name';

    /**
     * @var string Название категории
     */
    public $name = null;

    /**
     * @var string Короткое описание категории
     */
    public $description = null;

    /**
     * Вставка новой записи в БД
     */
    public function insert()
    {
        // Вставляем категорию
        $sql = "INSERT INTO $this->tableName ( name, description ) VALUES ( :name, :description )";
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
        $st->execute();
        $this->id = $this->pdo->lastInsertId();

    }

    /**
     * Обновляем текущий объект Category в базе данных.
     */

    public function update()
    {
        // Обновляем категорию
        $sql = "UPDATE $this->tableName SET name=:name, description=:description WHERE id = :id";
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );
        $st->execute();

    }

    /**
     * @param $array
     * @return array
     */
    protected static function toAssoc($array): array
    {
        $assocArray = [];
        foreach ($array as $el) {
            $assocArray[$el->id] = $el->name;
        }
        return $assocArray;
    }
    /**
     * @return array
     * Возвращает список категорий в виде ассоциативного массива
     */
    public static function getCategoriesAssoc()
    {
        $categories = (new self)->getList()['results'];
        return self::toAssoc($categories);
    }

}
