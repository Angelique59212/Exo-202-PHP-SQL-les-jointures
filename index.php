<?php
require 'Connect.php';
require 'Config.php';

$myConnexion = Connect::dbConnect();
/**
 * 1. Commencez par importer le script SQL disponible dans le dossier SQL.
 * 2. Connectez vous à la base de données blog.
 */

/**
 * 3. Sans utiliser les alias, effectuez une jointure de type INNER JOIN de manière à récupérer :
 *   - Les articles :
 *     * id
 *     * titre
 *     * contenu
 *     * le nom de la catégorie ( pas l'id, le nom en provenance de la table Categorie ).
 *
 * A l'aide d'une boucle, affichez chaque ligne du tableau de résultat.
 */

// TODO Votre code ici.
$request = $myConnexion->prepare("
    SELECT article.id,article.title,article.content,categorie.name
    FROM article
    INNER JOIN categorie ON article.category_fk = categorie.id
");

$state = $request->execute();
if ($state) {
    foreach ($request->fetchAll() as $value) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}


/**
 * 4. Réalisez la même chose que le point 3 en utilisant un maximum d'alias.
 */

// TODO Votre code ici.
$request = $myConnexion->prepare("
    SELECT ar.id,ar.title,ar.content,cat.name
    FROM article as ar
    INNER JOIN categorie as cat ON ar.category_fk = cat.id
");

$state = $request->execute();
if ($state) {
    foreach ($request->fetchAll() as $value) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}

/**
 * 5. Ajoutez un utilisateur dans la table utilisateur.
 *    Ajoutez des commentaires et liez un utilisateur au commentaire.
 *    Avec un LEFT JOIN, affichez tous les commentaires et liez le nom et le prénom de l'utilisateur ayant écris le comentaire.
 */

// TODO Votre code ici.
$stmt = $myConnexion->prepare("
    INSERT INTO utilisateur (firstName,lastName,mail,password)
    VALUES (:firstName,:lastName,:mail,:password)
");

$firstName = 'Angel';
$lastName = 'Dehainaut';
$mail = 'dehainaut.angelique@orange.fr';
$password = 'azerty';

$stmt->bindParam(':firstName',$firstName);
$stmt->bindParam(':lastName',$lastName);
$stmt->bindParam(':mail',$mail);
$stmt->bindParam(':password',$password);

$stmt->execute();

$request = $myConnexion->prepare("
    SELECT comm.content,ut.firstName,ut.lastName
    FROM commentaire as comm
    LEFT JOIN utilisateur as ut ON comm.user_fk = ut.id
");

$state = $request->execute();
if ($state) {
    foreach ($request->fetchAll() as $value) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}