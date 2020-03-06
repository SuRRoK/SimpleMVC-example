<?php

namespace application\models;

use ItForFree\SimpleMVC\mvc\Model;

/**
 * Description of AuthUsers
 *
 * @author qwe
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

    public function insert() {

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

    public function update() {

        // Обновляем категорию
        $sql = "UPDATE categories SET name=:name, description=:description WHERE id = :id";
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );
        $st->execute();

    }

}
