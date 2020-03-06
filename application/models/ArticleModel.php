<?php

namespace application\models;

use ItForFree\SimpleMVC\mvc\Model;

/**
 * Description of AuthUsers
 *
 * @author qwe
 */
class ArticleModel extends Model
{
    /**
     * Имя таблицы с категориями
     */
    public $tableName = 'articles';
    
    /**
     * @var string Критерий сортировки строк таблицы
     */
    public $orderBy = 'timestamp DESC';

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
     * @var string Первые 50 символов статьи
     */
    public $shortContent = null;
    /**
     * @var int Статус статьи (
     * is_active = 1 Отображается
     * is_active = 0 Скрыта
     */
    public $isActive = null;

    /**
     * @var int ID подкатегории статьи
     */
    public $subcategoryId = null;

    /**
     * @var Array Ассоциативный массив ID -> login авторов статьи
     */
    public $authors = null;




}
