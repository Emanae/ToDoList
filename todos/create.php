<?php require_once 'dbConnexion.php'; ?>
<?php include_once 'header.php' ?>
<?php include_once 'function.php' ?>
<?php 
if (!empty($_POST['name']) && isset($_POST['submit'])){
        
        $name=sanitize_string(htmlspecialchars($_POST['name']));
        $content = sanitize_string(htmlspecialchars($_POST['content']));

        $sql = "INSERT INTO todo (name, content) VALUES(:name,:content);";
        $todosStmt = $db->prepare($sql);
        $todosStmt->execute([
            'name'=> $name,
            'content'=> $content,
        ]);
        
        header('Location: index.php');die();

    }
elseif (isset($_POST['submit'])){
    echo "<script>alert(\"Vous devez entrer un nom\")</script>";
}



?>

    <h1>Create New Todo</h1>
    <form action="" method="post">
        <div class='containerTodo'>
            <label for="name">Name</label>
            <input type="text" name="name">
            <label for="content">Description</label>
            <input type="content" name = "content">
            <button type="submit" name="submit" class='otherButtons'> Add new Todo</button>
        </div>
    </form>

</body>    
