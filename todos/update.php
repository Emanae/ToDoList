<?php include_once 'function.php';?>
<?php include_once 'header.php' ?>
<?php require_once 'dbConnexion.php';

if (isset($_POST['name']) && isset($_POST['content'])&& isset($_POST['id'])){
    $name=sanitize_string(htmlspecialchars($_POST['name']));
    $content = sanitize_string(htmlspecialchars($_POST['content']));
    $id = sanitize_string(htmlspecialchars($_POST['id']));
    $sql = "UPDATE todo SET name = :name, content = :content WHERE id =:id ";
    $todosStmt = $db->prepare($sql);
    $todosStmt->execute([
        'name'=> $name,
        'content'=> $content,
        'id' => $id,
    ]);

    header('Location: index.php');die();

}
elseif (isset($_POST['submit'])){
    echo "<script>alert(\"Vous devez entrer un nom\")</script>";
}
if (isset($_GET['id'])){
    $id = sanitize_string(htmlspecialchars($_GET['id']));
    $sql = "SELECT name, content, id FROM todo WHERE id = :id";
    $todosStmt = $db->prepare($sql);
    $todosStmt->bindParam(':id', $id, PDO::PARAM_STR);
    $todosStmt->execute();
    $todos = $todosStmt->fetchAll();
    ?>
        <h1>Update Todo</h1>
        <form action="" method="post">
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" value = "<?=$todos[0]['name']?>">
                <label for="content">Description</label>
                <input type="content" name = "content" value= "<?=$todos[0]['content']?>">
                <input id=id name=id type="hidden" value="<?= $todos[0]['id'] ?>">
                <button type="submit" name="submit" class = "otherButtons"> Update Todo</button>
            </div>
        </form>
    </body>   
    
<?php
    
}