<?php
include_once 'function.php' ;
require_once 'dbConnexion.php';

if (isset($_GET['id'])){
    $id = sanitize_string(htmlspecialchars($_GET['id']));
    $sql = "SELECT done FROM todo WHERE id = :id";
    $todosStmt = $db->prepare($sql);
    $todosStmt->bindParam(':id', $id, PDO::PARAM_STR);
    $todosStmt->execute();
    $todos = $todosStmt->fetchAll();
    $statu = ($todos[0]['done'] + 1)%2;

    $sql = "UPDATE todo SET done = :statu WHERE id = :id";
    $todosStmt = $db->prepare($sql);
    $todosStmt->bindParam(':id', $id, PDO::PARAM_STR);
    $todosStmt->bindParam(':statu', $statu, PDO::PARAM_STR);
    $todosStmt->execute();
}
header('Location: index.php');die();