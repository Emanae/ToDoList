<?php include_once 'function.php' ;
require_once 'dbConnexion.php';
if (isset($_GET['id'])){
    $id = sanitize_string(htmlspecialchars($_GET['id']));
    $sql = 'DELETE FROM todo WHERE id = :id';
    $todosStmt = $db->prepare($sql);
    $todosStmt->bindParam(':id', $id, PDO::PARAM_STR);
    $todosStmt->execute();

}

header('Location: index.php');die();