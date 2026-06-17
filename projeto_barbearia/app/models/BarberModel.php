
<?php

class BarberModel extends Model
{
    private $pdo;

    public function __construct()
    {
        $conn = $this->getConnection();
        $this->pdo = $conn;
    }

    public function create($name)
    {
        $sql = "INSERT INTO `barber` (`name`) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ":name" => $name,
        ];

        try {
            $stmt->execute($params);
            return $this->pdo->lastInsertId() > 0;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function allBarbers()
    {
        $sql = "SELECT * FROM `barber` ORDER BY `name`";

        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function update($name,$id)
    {
        $sql = "UPDATE `barber` SET `name` = :name WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ":name" => $name,
            ":id" => $id,
        ];

        try {
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `barber` WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $params = [":id" => $id];

        try {
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function fetchByName($name)
    {
        $sql = "SELECT * FROM `barber` WHERE `name` = :name";
        $stmt = $this->pdo->prepare($sql);
        $params = [":name" => $name];

        try {
            $stmt->execute($params);
            return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
}
