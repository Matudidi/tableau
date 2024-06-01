
<?php
    // phpinfo();
    //https://api.thecompaniesapi.com/v1/locations/countries?token=YOUR_API_TOKEN

    include_once 'connection.php';  
    define("LIMIT_DISPLAY", 15);
    $parametre_requette = [];
    $statement = null;

    $requette = "SELECT* from etudiants";

    //systeme de recherche
    switch ($requette) {
        case   !empty($_GET['r_rechercheEtudiant']):
                    $requette .=" WHERE nom  like :nom";
                    $parametre_requette ['nom'] = '%'.$_GET['r_rechercheEtudiant'].'%';   
            break;
        
        default:
                 $_GET['r_rechercheEtudiant'] = null;
            break;
    }
    $requette .= " LIMIT ".LIMIT_DISPLAY. "";

    //preparation des requettes
    $statement = $connectionDatabase->prepare($requette);
    $statement->execute($parametre_requette);
    $listeEtudians = $statement->fetchAll();
    //var_dump($listeEtudians);


    //systeme de pagination
    $dbog = $connectionDatabase->query("SELECT count(etudiants.id) AS NOMBRE_ETUDIANT
            FROM etudiants
            WHERE etudiants.id");
        $nbEt = $dbog->fetch();
        $nombreEtus =    (int) $nbEt->NOMBRE_ETUDIANT;

        $pages = LIMIT_DISPLAY;
        $total_pages = ceil($nombreEtus / $pages);
       // var_dump($total_pages)

       $numero_page = null;

       if (isset($_POST['suivante'])) {
            $numero_page = (int) $_GET['p'];
            if ( $total_pages >1 ) {
                $offset_liste_etudiant = ($numero_page) * LIMIT_DISPLAY;
            }
       } else {
         $numero_page = 1;
       }

        //customisation coding...
       $monStyle1 = "style.css"; 
       $monStyle2 ="style copy.css";
       $couleur = $monStyle1;

       if(isset($_POST['dark'])){
            $couleur = $monStyle2;
       }else {
        $couleur = $monStyle1;
       }

?>


<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTE ETUDIANTS</title>
    <link rel="stylesheet" href="<?= $couleur?>">
</head>
<body>
<div class="contenair">
        <div class="nav-bar">
            <p><a href="index.php">accueil</a></p>
            <p><a href="form.php">formulaire</a></p>
            <p><a href="rapport.php">rapport</a></p>
            <p><a href="listeEtudiant.php">Liste</a></p>
            <p>historique</p>
        </div>
        <form action="" method="GET">
            <input type="search" placeholder="recherche" name="r_rechercheEtudiant" value="<?= htmlentities($_GET['r_rechercheEtudiant']);?>">
            <input type="submit" value="rechercher" class="bnt bnt-primary">
        </form>
    </div>
    <br>
    <h3>Liste des etudiants</h3>

    <div class="tab-contenair">
        <table> 
            <thead>
                <tr>
                    <th>N°</th>
                    <th>NOM</th>
                    <th>POSTNOM</th>
                    <th>PRENOM</th>
                    <th>SEXE</th>
                    <th>LIEU/NAIS</th>
                    <th>DEPARTEMENT</th>
                    <th>FACULTE</th>
                </tr>
                
                <tr>
                    <th><input type="search" placeholder ="filtrer"></th>
                    <th><input type="text" placeholder ="filtrer"></th>
                    <th><input type="text" placeholder ="filtrer"></th>
                    <th><input type="text" placeholder ="filtrer"></th>
                    <th><input type="text" placeholder ="filtrer"></th>
                    <th><input type="text" placeholder ="filtrer"></th>
                    <th><input type="text" placeholder ="filtrer"></th>
                    <th><input type="text" placeholder ="filtrer"></th>
                </tr>
                
            </thead>
            <tbody>
            
            <?php foreach ($listeEtudians as $for_etudiant):?>
                <tr>
                    <td> <?= $for_etudiant->nom?></td>
                    <td> <?= $for_etudiant->nom?></td>
                    <td>  <?= $for_etudiant->postnom?></td>
                    <td>  <?= $for_etudiant->prenon?></td>
                    <td> <?= $for_etudiant->sexe?></td>
                    <td> <?= $for_etudiant->lieu_date_naiss?> </td>
                    <td> <?= $for_etudiant->departement?>  </td>
                    <td> <?= $for_etudiant->faculte?></td>
                </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>

    <h1>
    <?php  if ($total_pages > 1 ):?>
        <a href="?p=<?= $total_pages?> ">
            <input type="submit" name="suivante" id="" value=" page suisvante">
        </a>
    <?php endif;?>

        <form action="" method="post">
        <input type="submit" name="dark" id="" value="dark">
        <input type="submit" name="ligth" id="" value="ligth">
        </form>
    </h1>

</body>
</html>

