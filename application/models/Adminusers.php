<?php

namespace application\models;

/**
 * Description of AuthUsers
 *
 * @author qwe
 */
class Adminusers extends BaseExampleModel
{
    /**
     * Имя таблицы пользователей
     */
    public $tableName = 'users';
    
    /**
     * @var string Критерий сортировки строк таблицы
     */
    public $orderBy = 'timestamp DESC';
    
    /**
     * Логин пользователя
     * @var type 
     */
    public $login = null;
    
    /**
     * Логин пользователя
     * @var type 
     */
    public $salt = null;
    /**
     * @var type 
     */
    public $pass = null;
    
    /**
     * @var type 
     */
    public $email = null;
    
    /**
     * @var type 
     */
    public $id = null;
    
    /**
     * @var type 
     */
    public $timestamp = null;
    
    /**
     * @var type 
     */
    public $role = null;
    

    
    /**
     * Добавляем нового пользователя
     */
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (timestamp, login, salt, pass, role, email) VALUES (:timestamp, :login, :salt, :pass, :role, :email)"; 
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":timestamp", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT);
        $st->bindValue( ":login", $this->login, \PDO::PARAM_STR );
        
        //Хеширование пароля
        $this->salt = rand(0,1000000);
        $st->bindValue( ":salt", $this->salt, \PDO::PARAM_STR );

        $this->pass .= $this->salt;
        $hashPass = password_hash($this->pass, PASSWORD_BCRYPT);
        $st->bindValue( ":pass", $hashPass, \PDO::PARAM_STR );
        $st->bindValue( ":role", $this->role, \PDO::PARAM_STR );
        $st->bindValue( ":email", $this->email, \PDO::PARAM_STR );
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }

    /**
    * Обновляем текущий объект статьи в базе данных
    */
    public function update()
    {
        $sql = "UPDATE $this->tableName SET timestamp=:timestamp, login=:login, pass=:pass, salt=:salt, role=:role, email=:email  WHERE id = :id";
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":timestamp", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT);
        $st->bindValue( ":login", $this->login, \PDO::PARAM_STR );

        if ($this->pass !== '') {
            // Хеширование пароля
            $this->salt = rand(0,1000000);
            $this->pass .= $this->salt;
            $hashPass = password_hash($this->pass, PASSWORD_BCRYPT);
        } else {
            $prevData = new Adminusers();
            $prevData =$prevData->getById((int)$this->id);
            $hashPass = $prevData->pass;
            $this->salt = $prevData->salt;
        }

        $st->bindValue( ":pass", $hashPass, \PDO::PARAM_STR );
        $st->bindValue( ":salt", $this->salt, \PDO::PARAM_STR );
        $st->bindValue( ":role", $this->role, \PDO::PARAM_STR );
        $st->bindValue( ":email", $this->email, \PDO::PARAM_STR );
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );
        $st->execute();
    }

    /**
     * @return array
     * Возвращает список пользователей в виде ассоциативного массива id -> login
     */
    public static function getAllAssoc(): array
    {
        $thisEl = new static();
        $sql = "SELECT id, login FROM $thisEl->tableName
                ORDER BY login";
        $st = $thisEl->pdo->prepare($sql);
        $st->execute();

        return $st->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

}
