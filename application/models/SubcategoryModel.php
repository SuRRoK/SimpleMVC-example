<?php

namespace application\models;


/**
 * Description of Subcategory
 *
 * @author surrok
 */
class SubcategoryModel extends CategoryModel
{
    /**
     * Имя таблицы с подкатегориями
     */
    public $tableName = 'subcategories';

    /**
     * @var string Критерий сортировки строк таблицы
     */
    public $orderBy = 'name';

    /**
     * @var int ID категории, к которой относится подкатегория из БД
     */
    public $categoryId = null;

    /**
     * Вставка новой записи в БД
     */
    public function insert()
    {
        // Вставляем категорию
        $sql = "INSERT INTO $this->tableName ( name, description, categoryId ) VALUES ( :name, :description, :categoryId )";
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
        $st->bindValue( ":categoryId", $this->categoryId, \PDO::PARAM_STR );
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
        $st->bindValue( ':name', $this->name, \PDO::PARAM_STR );
        $st->bindValue( ':description', $this->description, \PDO::PARAM_STR );
        $st->bindValue( ':id', $this->id, \PDO::PARAM_INT );
        $st->execute();

    }

    /**
     * @return array
     * Возвращает список категорий в виде ассоциативного массива
     */
    public static function getSubcategoriesAssoc(): array
    {
        $subcategories = (new self)->getList()['results'];
        return self::toAssoc($subcategories);
    }
}
