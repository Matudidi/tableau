

<?php
 
    
    include_once 'connection.php';

    $rte = "SELECT *FROM etudiantsTable";
    $query_count = "SELECT count(id_etudiant) as count from etudiantsTable";
    define("PER_PAGE", 50);

    $params = [];
    if (!empty($_GET['r'])) {
        $rte .= " WHERE nom LIKE :nom";
        $params ['nom'] = '%'.$_GET['r'].'%';
    }
    $rte .= " LIMIT ".PER_PAGE;


    //pagination

    $page = $_GET['p'] ;

    $statement = $connectionDatabase->prepare($rte);
    $statement->execute($params);
    $liste_etudiants  = $statement->fetchAll();

    $statement = $connectionDatabase->prepare($query_count);
    $statement->execute();
    $count = $statement->fetch();

    $count_pers = $count->count;

    $pages = ceil($count_pers / PER_PAGE);

    
?>

<!DOCTYPE html>
<html lang="fr-FR"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTE ETUDIANTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="contenair">
        <div class="nav-bar">
            <p><a href="index.php">accueil</a></p>
            <p><a href="form.php">formulaire</a></p>
            <p><a href="rapport.php">rapport</a></p>
            <p><a href="">statistique</a></p>
            <p>historique</p>
        </div>
        <form action="" method="GET">
            <input type="search" placeholder="recherche" name="r" value="<?= htmlspecialchars($_GET['r']);?>  ">
            <input type="submit" value="rechercher" class="bnt bnt-primary">
        </form>
    </div>
    <div class="tab-contenair">
    <table> 
        <thead>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>POSTNOM</th>
                <th>DEPARTEMENT</th>
                <th>FACULTE</th>
                <th>MONTANT</th>
                <th>DATE</th>
                <th>DECISION</th>
            </tr>
        </thead>
        <tbody>

        <?php
            foreach ($liste_etudiants as $etudiant):
            
            
            ?>
        
            <tr>
                <td> <?=$etudiant->id_etudiant?> </td>
                <td><?=$etudiant->nom?></td>
                <td><?=$etudiant->postnom?></td>
                <td><?=$etudiant->departement?></td>
                <td><?=$etudiant->faculter?></td>
                <td> <?= number_format($etudiant->montant, 0,'', ',');?> ,00  fc</td>
                <td> <?=$etudiant->date?></td>
                <td> <?php
                    switch ($etudiant) {
                        case $etudiant->montant >400000:
                            $new_decision = $connectionDatabase->query("UPDATE etudiantsTable SET decision='EN ORDRE' WHERE id_etudiant = id_etudiant");
                                echo '<p>';
                                    print($etudiant->decision);
                                echo '</p>';
                            break;
                        
                        default:
                                echo'<label>';
                                    printf('NON EN ORDRE');
                                echo'</label>';
                            break;
                    }
                ?>
                </td>
            </tr>

            <?php endforeach ?>
        </tbody>
    </table>

    </div>
    <h1>
    <?php
        if ($pages > 1 ): ?>
        <a href="?p=".<?= $page + 1 ?> >
            <input type="submit" name="suivante" id="" value="page suivante">
        </a>
        <?php endif ?>
    </h1>





    <a href="">
            <input type="submit" name="suivante" id="" value="page precedante">
        </a> 
    <br><br>
    <br><br>
</body>
</html>