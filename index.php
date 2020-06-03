<?php

require_once ('connect.php');

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Mes amis</title>
</head>
<body>    
    <br>
    <?php
    echo "<ul>" . PHP_EOL;
    echo "<li>";
    echo "Prénom" . ' | ' . "Nom";
    echo "</li>" . PHP_EOL;
    foreach($friends as $friend) {
        echo "<li>" . $friend['firstname'] . ' | ' . $friend['lastname'] . "</li>" . PHP_EOL;
    }        
    echo "</ul>"; 
    ?>
    <br>
    <form  action="index.php"  method="post">
        <div>
            <label for="firstname">Prénom :</label>
            <input type="text"  id="firstname" name="firstname" required>
        </div>
        <div>
            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>
        <div >
            <button type="submit" id="submit" name="add">Submit</button>
        </div>
    </form>
    <?php 
     
    if(isset($_POST['firstname'])) {     
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
    
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $stm = $pdo->prepare($query);
    
        $stm->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $stm->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    
        $stm->execute();

        $_POST['firstname'] = '';
        $_POST['lastname'] = '';

        //redirect
        header('location: index.php');
    }
    ?>

</body>
</html>