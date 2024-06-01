<?php
    try {
        include_once 'connection.php';
        
        define('CONNECTION_DB', $connectionDatabase->query(''));
        define ("LIMITE_AFICHAGE", 20);
        $paramettre = [];

        

        $requette = "SELECT
                    etudiants.id,  
                    etudiants.nom, 
                    etudiants.postnom, 
                    etudiants.departement,
                    etudiants.prenon,
                    etudiants.sexe,
                    etudiants.faculte,
            sum(fraistables.nontant) as total_payer
        FROM fraistables,etudiants 
        WHERE fraistables.id_etudiant = etudiants.id ";

        if (!empty($_GET['r_recherche'])) {
            $requette .= " LIKE :nom";
            $paramettre ['nom'] = "%" .$_GET['r_recherche'] . "%";
        }

        $requette .= "  GROUP BY fraistables.id_etudiant 
                HAVING SUM(fraistables.nontant) >0 
                ORDER BY etudiants.nom ASC  LIMIT ". LIMITE_AFICHAGE ;

        $statement = $connectionDatabase->prepare($requette);
        $statement->execute($paramettre);
        $listes_etudiants = $statement->fetchAll();


    } catch (Exception $exepception) {
        echo('erreur se trouve: '.$exepception);
    }
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
            <p>historique</p>
            <p>rapport</p>
            <p>statistique</p>
        </div>
        <form action="" method="GET">
            <input type="search" placeholder="recherche" name="r_recherche" value="<?= $_GET['r_recherche'] ?>  ">
            <input type="submit" value="rechercher" class="bnt bnt-primary">
        </form>
    </div>
   

    <div class="tab-contenair">
    <table> 
        <thead>
        <h2>Rapport generale de payement</h2>
            <tr>
                <th>N°</th>
                <th>NOM</th>
                <th>POSTNOM</th>
                <th>PRENOM</th>
                <th>SEXE</th>
                <th>DEPARTEMENT</th>
                <th>FACULTE</th>
                <th>TOTAL PAYER</th>
                <th>RESTE</th>
                <th>DECISION</th>
            </tr>
            <!-- #region 
            <tr>
                <th> </th>
                <th><input type="search" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
                <th><input type="text" placeholder ="filtrer"></th>
            </tr>
            -->
        </thead>
        <tbody>
            
        <?php foreach ($listes_etudiants as $etudiant): 
            
            ?>
            <tr>
                <td> <?= $etudiant->id?> </td>
                <td> <?= $etudiant->nom ?> </td>
                <td> <?= $etudiant->postnom ?> </td>
                <td> <?= $etudiant->prenon ?> </td>
                <td> <?= $etudiant-> sexe?> </td>
                <td> <?= $etudiant->departement ?> </td>
                <td> <?= $etudiant->faculte ?>  </td>
                <td> <?= number_format($etudiant->total_payer) ?>, 00 fc </td>
                <td> <?= number_format( 500000 - $etudiant->total_payer)?>,00 fc</td>
                <td> <?php
                    switch ($etudiant) {
                        case  $etudiant->total_payer < 16000 :
                            echo '<label>';
                                print_r ("NON EN ORDRE");
                            echo '</label>';
                            break;
                        

                        case $etudiant->total_payer  > 500000:
                            echo '<h5>';
                                print_r (" DEPASSEMENT");
                            echo '</h5>';
                            break;
                        default:
                            echo '<p>';
                                print_r (" EN ORDRE");
                            echo '</p>';
                            break;
                    }
                
                ?> </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    </div>
    
</body>
</html>