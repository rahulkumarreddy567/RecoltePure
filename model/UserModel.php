<?php

//registration

class UserModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Check if email exists in a specific table
    public function emailExists($email, $role) {
        $table = ($role === 'farmer') ? 'farmer' : 'users';
        $idField = ($role === 'farmer') ? 'farmer_id' : 'customer_id';

        // Note: We use dynamic table names carefully here since $role is controlled by us in the controller
        $query = "SELECT $idField FROM $table WHERE email = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    public function registerFarmer($fullName, $email, $phone, $address, $certNumber, $passwordHash) {
        $stmt = $this->db->prepare("INSERT INTO farmer (name, email, phone_number, address, certificate_number, password_hash) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullName, $email, $phone, $address, $certNumber, $passwordHash);
        return $stmt->execute();
    }

    public function registerUser($fullName, $email, $address, $passwordHash) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, address, password, registration_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $fullName, $email, $address, $passwordHash);
        return $stmt->execute();
    }
}
?>