<?php

// handles all db queries
class DatabaseCrud
{
    private PDO $db;
    private PDOStatement $stmt;
    private static $_instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): object
    {
        $class = get_called_class();
        if (self::$_instance === null) {
            self::$_instance = new $class;
        }
        return self::$_instance;
    }

    public function connectToDB($servername, $username, $password, $dbname): void
    {
        try {
            $this->db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    public function rollBack()
    {
        $this->db->rollBack();
    }

    public function commit()
    {
        $this->db->commit();
    }

    private function executeQuery(string $sql, array $params): bool
    {
        try {
            $this->stmt = $this->db->prepare($sql);
            return $this->stmt->execute($params);
        } catch (PDOException $e) {
            print($e->getCode() . ":" . $e->getMessage());
            return false;
        }
    }

    public function selectOne(string $sql, array $params = []): array|false
    {
        if ($this->executeQuery($sql, $params)) {
            $this->stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $this->stmt->fetch();
        }
        return false;
    }

    public function selectMany(string $sql, array $params = []): array|false
    {
        if ($this->executeQuery($sql, $params)) {
            $this->stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $this->stmt->fetchAll();
        }
        return false;
    }

    public function doInsert(string $sql, array $params = []): int|bool
    {
        if ($this->executeQuery($sql, $params)) {
            // if query executes properly but returns 0, that table doesn't have an ID, 
			// return true to indicate success in spite of that
            return $this->db->lastInsertId() == 0 ? true : $this->db->lastInsertId();
        }
        return false;
    }

    public function doUpdate(string $sql, array $params = []): int|false
    {
        if ($this->executeQuery($sql, $params)) {
            return $this->stmt->rowCount();
        }
        return false;
    }

    public function doDelete(string $sql, array $params = []): int|false
    {
        if ($this->executeQuery($sql, $params)) {
            return $this->stmt->rowCount();
        }
        return false;
    }
}
