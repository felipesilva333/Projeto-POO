<?php

class ScheduleModel extends Model
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function create($user, $tel, $email, $barber_id, $service_id, $datetime, $message, $user_id)
    {
        // 🚨 Verifica se o horário já está ocupado
        if ($this->isDatetimeTaken($datetime, $barber_id)) {
            throw new PDOException("Este horário já está reservado para outro cliente.");
        }

        $sql = "INSERT INTO `schedule` (`user`, `tel`, `email`, `barber_id`, `service_id`, `datetime`, `message`, `user_id`) 
                VALUES (:user, :tel, :email, :barber_id, :service_id, :datetime, :message, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':user' => $user,
            ':tel' => $tel,
            ':email' => $email,
            ':barber_id' => $barber_id,
            ':service_id' => $service_id,
            ':datetime' => $datetime,
            ':message' => $message,
            ':user_id' => $user_id
        ];

        try {
            $stmt->execute($params);
            return $this->pdo->lastInsertId() > 0;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
    

    // 🚨 Função para verificar se o horário já está reservado para o barbeiro
    public function isDatetimeTaken($datetime, $barber_id)
    {
        $sql = "SELECT COUNT(*) as count FROM `schedule` WHERE `datetime` = :datetime AND `barber_id` = :barber_id";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':datetime' => $datetime,
            ':barber_id' => $barber_id
        ];

        try {
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0; // Retorna true se houver conflito
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function allSchedules()
    {
        $sql = "SELECT `schedule`.*, `service`.`name` as `service`, `service`.`price` as `service_price`, `barber`.`name` as `barber_name` 
                FROM `schedule` 
                INNER JOIN `service` ON `service`.`id` = `schedule`.`service_id` 
                INNER JOIN `barber` ON `barber`.`id` = `schedule`.`barber_id` 
                ORDER BY `datetime`";

        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function update($user, $tel, $service_id, $barber_id, $datetime, $message, $id)
    {
        // 🚨 Verifica se o horário já está ocupado ao atualizar
        if ($this->isDatetimeTaken($datetime, $barber_id)) {
            throw new PDOException("Este horário já está reservado para outro cliente.");
        }

        $sql = "UPDATE `schedule` SET `user` = :user, `tel` = :tel, `service_id` = :service_id, 
                `barber_id` = :barber_id, `datetime` = :datetime, `message` = :message 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':user' => $user,
            ':tel' => $tel,
            ':service_id' => $service_id,
            ':barber_id' => $barber_id,
            ':datetime' => $datetime,
            ':message' => $message,
            ':id' => $id
        ];

        try {
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function updateStatus($status, $id)
    {
        $sql = "UPDATE `schedule` SET `status` = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':status' => $status,
            ':id' => $id
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
        $sql = "DELETE FROM `schedule` WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $params = [':id' => $id];

        try {
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function fetchByUser($user)
    {
        $sql = "SELECT `schedule`.*, `service`.`name`, `service`.`price`, `barber`.`name` as `barber_name` 
                FROM `schedule` 
                INNER JOIN `service` ON `service`.`id` = `schedule`.`service_id` 
                INNER JOIN `barber` ON `barber`.`id` = `schedule`.`barber_id`
                WHERE `user_id` = :user";
        $stmt = $this->pdo->prepare($sql);
        $params = [':user' => $user];

        try {
            $stmt->execute($params);
            return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [false];
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
}
