<?php

require_once "../inc/init.php";

    if( !isAdmin() ){ 
        header("location:../profil.php");
        exit;
    }

// ETAPE de modification des données
     if( isset($_GET['action']) && $_GET['action'] == "modifier") { 

        // Récupération du membre sélectionné 
        $requete = $bdd->prepare("SELECT * FROM membre WHERE id = :id");
        $requete->execute([":id" => $_GET['id_membre']]);

        $membre_select = $requete->fetch();
        // debug($membre_select);

        // Je vérifie si le formulaire a été validé 
        if ( !empty($_POST) ) {

            // Sécurisation des données
                foreach($_POST as $key => $value){
                    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
                }
            // FIN Sécurisation des données

            // Vérification des données 
                if (empty($_POST['username'])) {
                    $errorMessage .= "Merci d'indiquer un pseudo <br>";
                }
                // strlen() permet de récupérer la longueur d'une chaine de caractère. Attention les caractères spéciaux compte pour 2. Exemple : éé comptera pour 4 caractères 
                // iconv_strlen() permet de résoudre ce problème. Chaque caractère comptera comme 1. Exemple: éé comptera pour 2 caractères
                if (
                    iconv_strlen(trim($_POST['username'])) < 3
                    || strlen(trim($_POST['username'])) > 20
                ) {
                    $errorMessage .= "Le pseudo doit contenir entre 3 et 20 caractères <br>";
                }
            
                if (empty($_POST['lastname']) || iconv_strlen(trim($_POST['lastname'])) > 70) {
                    $errorMessage .= "Merci d'indiquer un nom (maximum 70 caractères)<br>";
                }
            
                if (empty($_POST['firstname']) || iconv_strlen(trim($_POST['firstname'])) > 70) {
                    $errorMessage .= "Merci d'indiquer un prénom (maximum 70 caractères)<br>";
                }
            
                if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errorMessage .= "L'email n'est pas valide<br>";
                }
                // in_array() permet de vérifier si une valeur est présente dans un tableau de données.
                // Ici, si j'ai une valeur différente de 'user' ou 'admin' alors j'affiche un message d'erreur.
                // Attention au select/option (menu déroulant). Si aucune option n'est sélectionnée, l'indice ne sera pas créé dans la superglobale $_POST. Il faudra donc vérifier s'il existe avant de l'utiliser
                if (isset($_POST['status']) && !in_array($_POST['status'], ['user', 'admin'])) {
                    $errorMessage .= "Le status sélectionné n'est pas reconnu <br>";
                }
            // FIN Vérification des données 

            // Je vérifie si je n'ai pas le message d'erreur
            if (empty($errorMessage)) {
                
                // Update des données.
                $requete = $bdd->prepare("UPDATE membre SET username = :username, lastname = :lastname, firstname = :firstname, email = :email, status = :status WHERE id = :id");
                $success = $requete->execute([
                    ':username' => $_POST['username'],
                    ':lastname' => $_POST['lastname'],
                    ':firstname' => $_POST['firstname'],
                    ':email' => $_POST['email'],
                    ':status' => $_POST['status'],
                    ':id' => $_GET['id_membre'],

                ]);

                if ($success) {
                    $successMessage = "Le membre a bien été modifié !";
                } else {
                    $errorMessage = "Erreur lors de la modification";
                }
                

            }
            

        }

    } 
// FIN de modification des données

// ETAPE de suppression d'un membre
    // Je vérifie si l'indice 'action' dans la superglobale dans $_GET existe. Si il existe et que sa valeur est égale à 'supprimer' alors je rentre dans la condition. 
    if ( isset($_GET['action']) && $_GET['action'] == "supprimer" ) {
        debug($_GET);

        // Vérifier si la ligne cliqué correspond ou non à la personne connecté 
        if ( $_SESSION['membre']['id'] != $_GET['id_membre']) {

            $requete = $bdd->prepare("DELETE FROM membre WHERE id = :id");
            $success = $requete->execute([':id' => $_GET['id_membre']]);

            if ($success) {
                $successMessage = "Le membre a bien été supprimé !";
            } else {
                $errorMessage = "Erreur lors de la suppression du membre";
            }

             
        } else {
            $errorMessage = "Attention vous ne pouvez pas supprimer votre compte !";
        }


    }
// FIN de suppression d'un membre

// ETAPE de récupération des membres
    $requete = $bdd->prepare("SELECT * FROM membre"); // je prépare la requête 
    $requete->execute(); // j'execute la requête
    $membres = $requete->fetchAll(); // je vais chercher à l'intéreiru de l'objet PDOStatement les membres 
// FIN de récupération des membres 


require_once "../inc/header.php";
?>

<h1 class="text-center">Gestion Membres</h1>

<?php if (!empty($successMessage)) { ?>
    <div class="alert alert-success col-md-6 text-center mx-auto">
        <?php echo $successMessage ?>
    </div>
<?php } ?>

<?php if (!empty($errorMessage)) { ?>
    <div class="alert alert-danger col-md-6 text-center mx-auto">
        <?php echo $errorMessage ?>
    </div>
<?php } ?>

<!-- Affichage des données -->
<table class="table table-striped table-hover table-bordered">

    <thead>
        <tr>
            <th>ID</th>
            <th>Pseudo</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <!-- Affichage des utilisateurs -->
        <?php foreach ($membres as $membre) { ?>
            <tr>
                <td><?= $membre['id'] ?></td>
                <td><?= $membre['username'] ?></td>
                <td><?= $membre['lastname'] ?></td>
                <td><?= $membre['firstname'] ?></td>
                <td><?= $membre['email'] ?></td>
                <td><?= $membre['status'] ?></td>
                <td>
                    <a class="btn btn-sm btn-warning" href="gestion_membre.php?action=modifier&id_membre=<?= $membre['id'] ?>">Modifier</a>
                    <a class="btn btn-sm btn-danger" href="gestion_membre.php?action=supprimer&id_membre=<?= $membre['id'] ?>" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')"
                    >Supprimer</a>
                </td>
            </tr>
        <?php  } ?>
    </tbody>

</table>

<!-- Formulaire de la modification -->
<?php if( isset($_GET['action']) && $_GET['action'] == "modifier") { ?>
    <h4 class="text-center text-warning">Modifiez ici le membre</h4>

<form class="col-md-6 mx-auto" action="" method="post">

    <label class="form-label" for="username">Pseudo</label>
    <input 
        class="form-control" 
        type="text" 
        name="username" 
        id="username"
        value="<?= $membre_select['username'] ?>"
    >

    <label class="form-label" for="lastname">Nom</label>
    <input 
        class="form-control" 
        type="text" 
        name="lastname" 
        id="lastname"
        value="<?= $membre_select['lastname'] ?>"
    >

    <label class="form-label" for="firstname">Prénom</label>
    <input 
        class="form-control" 
        type="text"
        name="firstname"
        id="firstname"
        value="<?= $membre_select['firstname'] ?>"
    >

    <label class="form-label" for="email">Email</label>
    <input 
        class="form-control" 
        type="email" 
        name="email" 
        id="email"
        value="<?= $membre_select['email'] ?>"
    >

    <label class="form-label" for="status">Statut</label>
    <select class="form-select" name="status" id="status">
        <option selected disabled>Sélectionnez un statut</option>
        <option value="user" <?= $membre_select['status'] === 'user' ? "selected" : "" ?> >Utilisateur</option>
        <option value="admin" <?= $membre_select['status'] === 'admin' ? "selected" : "" ?> >Administrateur</option>
    </select>

    <button class="btn btn-warning d-block mx-auto my-4">Modifier</button>

</form>
<?php } ?>


<?php
require_once "../inc/footer.php";
