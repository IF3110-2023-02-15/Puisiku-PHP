<?php
class PSQL {
    private $pdo;

    public function __construct() {
        $host = getenv('PSQL_HOST');
        $port = getenv('PSQL_PORT');
        $dbname = getenv('PSQL_NAME');
        $user = getenv('PSQL_USER');
        $password = getenv('PSQL_PASSWORD');
    
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        
        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            // return $e->getMessage();
        }
    }    

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }
}
