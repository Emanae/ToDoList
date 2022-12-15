<?php include_once 'function.php' ?>
<?php include_once 'header.php' ?>
<?php require_once 'dbConnexion.php';

//  récupérera les todos de votre BDD et les affichera sous forme de liste.
//  Chaque ligne  boutons d'action "Modifier", "Supprimer" et "Terminer"
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = sanitize_string(htmlspecialchars($_GET['page']));
}else{
    $currentPage = 1;
}
$nbElements = 15;
$firstElement = ($currentPage * $nbElements) - $nbElements;

if (isset($_GET['search'])) {
    $search = sanitize_string(htmlspecialchars($_GET['search']));
    $sqlSearchCount = 'SELECT COUNT(*) FROM todo WHERE name LIKE :search';
    $todoCountStmt = $db->prepare($sqlSearchCount);
    $todoCountStmt->execute([
        'search'=>'%'.$search.'%'
    ]);
    $count = $todoCountStmt->fetchColumn();
    $pages = ceil($count / $nbElements);
    
    $sqlSearch = 'SELECT * FROM (SELECT * FROM todo WHERE name LIKE :search)AS Research LIMIT :nbElements OFFSET :firstElement;';
    $todosStmt = $db->prepare($sqlSearch);
    
    $todosStmt->bindValue(':firstElement', $firstElement, PDO::PARAM_INT);
    $todosStmt->bindValue(':nbElements', $nbElements, PDO::PARAM_INT);
    $todosStmt->bindValue(':search','%'.$search.'%', PDO::PARAM_STR);
    $todosStmt->execute();
    $todos = $todosStmt->fetchAll();
    }
else{
    $sqlCount = 'SELECT COUNT(*) FROM todo';
    $todoCountStmt = $db->prepare($sqlCount);
    $todoCountStmt->execute();

    $count = $todoCountStmt->fetchColumn();
    $pages = ceil($count / $nbElements);

    $sql = 'SELECT * FROM todo ORDER BY `id` DESC LIMIT :firstElement, :nbElements;';
    $todosStmt = $db->prepare($sql);
    $todosStmt->bindValue(':firstElement', $firstElement, PDO::PARAM_INT);
    $todosStmt->bindValue(':nbElements', $nbElements, PDO::PARAM_INT);
    
    $todosStmt->execute();
    $todos = $todosStmt->fetchAll();}
    

?>
    <h1>To-Do List</h1>
    <form>
        <input type="text" name="search" placeholder="Rechercher">
        <input type="submit" value="Rechercher" class='search'>
        <a class='add' href= "index.php">Annuler</a>
    </form>
    <div class = 'addContainer'>
        <a class='add' href= "create.php">Add</a>
    </div>
    
    <?php foreach ($todos as $todo): ?>
        
        <?php echo div($todo['done'], $todo['id']) ?>
            <div class= 'name'><?= $todo['name'] ?></div>
            <div class = 'content'><?= $todo['content'] ?></div>
            <div class = 'buttons'>
            <a class='button' href="update_status.php?id=<?= $todo['id'] ?>"><img src=./image/check.png></a>
            <a class='button' href="delete.php?id=<?= $todo['id'] ?>"><img src=./image/delete.png></a>
            <a class='button' href="update.php?id=<?= $todo['id'] ?>"><img src=./image/edit.png></a>
            </div>
        </div>
        
    <?php endforeach; ?>
    <ul class="pages">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for($page = 1; $page <= $pages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                    <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
</body>


