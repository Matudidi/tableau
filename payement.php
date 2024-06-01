<?php

include_once 'connection.php';

 $requette = $connectionDatabase->prepare('INSERT INTO fraistables (nontant, id_etudiant) 
 VALUES (:montant,  :id_etudiant:)');
    $requette->execute([
        'montant' => $_POST['montant'],
        'id_etudiant' => $_POST['id_etudiant']
    ]);

?>


<!DOCTYPE html>>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAYEMENT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contenair">
        <div class="nav-bar">
            <p><a href="index.php">accueil</a></p>
            <p><a href="form.php">formulaire</a></p>
            <p>historique</p>
            <p>rapport</p>
        </div>
        <form action="" method="GET">
            <input type="search" placeholder="recherche" name="r" value=" ">
            <input type="submit" value="rechercher" class="bnt bnt-primary">
        </form>
    </div>

    

    <main>
        <div class="main-left">

            <form action="" method="post">
                <input type="text" placeholder=" ID Etidiant" name="id_etudiant">
                <input type="text" placeholder="montant" name="montant">
                <textarea name="" id="">Motif payement</textarea>
                <input type="submit" value="valider">
            </form>
        </div>

        <div class="main-rigth">
            <table> 
                <thead>
                    <tr>
                        <th >ID</th>
                        <th>NOM</th>
                        <th>POSTNOM</th>
                        <th>DEPARTEMENT</th>
                        <th>FACULTE</th>
                        <th>MONTANT</th>
                        <th>RESTE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form action="" method="get">
                        <td>1 </td>
                        <td> MATUDIDI</td>
                        <td> MANZA</td>
                        <td> ENOCK</td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    
</body>
</html>