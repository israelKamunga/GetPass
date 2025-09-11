<?php
require_once (__DIR__.'/../config/db.php');

class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserByUsername($username,$password) {
        $sql = "SELECT * FROM " . $this->table . " WHERE username = :username AND userPassword = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajoute une entrée dans la table gatepass
    public function insertGatePass($data) {
        $sql = "INSERT INTO GATEPASS (ID_HOD, NAME_HOD, ID_SUPERVISOR, NAME_SUPERVISOR, DESCRIPTION, QUANTITY, Destination, CREATED_AT) 
                VALUES (:id_hod_manager, :name_hod_manager, :id_supervisor, :name_supervisor, :description, :quantity, :destination, :created_at)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_hod_manager', $data['id_hod_manager']);
        $stmt->bindParam(':name_hod_manager', $data['name_hod_manager']);
        $stmt->bindParam(':id_supervisor', $data['id_supervisor']);
        $stmt->bindParam(':name_supervisor', $data['name_supervisor']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':destination', $data['destination']);
        $stmt->bindParam(':created_at', date("Y-m-d H:i:s"));
        return $stmt->execute();
    }

    public function getAllGatePasses() {
        $sql = "SELECT * FROM GATEPASS ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGatePassByCreatedAt($created_at) {
        $sql = "SELECT * FROM GATEPASS WHERE DATE(created_at) = :created_at ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGatePassById($id) {
        $sql = "SELECT * FROM GATEPASS WHERE GATEPASS_ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
