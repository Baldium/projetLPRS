<?php
session_start();
require_once '../../utils/Bdd.php'; 
require_once '../../utils/mailjet.php';


// Page rapide faites par GPT !


if (!isset($_SESSION['id_society'])) {
    header("Location: ../connexion.php");
    exit;
}

if (!isset($_SESSION['id_users'])) {
    header('Location: ../connexion.php');
    exit();
}

$my_bdd = Bdd::my_bdd();
$id_society = $_SESSION['id_society'];

// Ajouter un employé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    $prenom = htmlspecialchars($_POST['employee_prenom']);
    $nom = htmlspecialchars($_POST['employee_nom']);
    $email = htmlspecialchars($_POST['employee_email']);
    $role_name = htmlspecialchars($_POST['employee_role']);
    $accepted = 1;
    
    // Vérifier si l'email existe déjà dans la base de données
    $stmt = $my_bdd->prepare("SELECT COUNT(*) FROM users WHERE mail = :mail");
    $stmt->execute([':mail' => $email]);
    $email_exists = $stmt->fetchColumn();

    if ($email_exists > 0) {
        echo "<script>alert('L\'email est déjà utilisé par un autre employé.');</script>";
    } else {
        $plain_password = generate_random_password(12);
        $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

        // Insérer dans la table users
        $stmt = $my_bdd->prepare("
            INSERT INTO users (nom, prenom, mail, password, role, ref_society, accepted) 
            VALUES (:nom, :prenom, :mail, :password, :employee_role, :ref_society, :accepted)
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':mail' => $email,
            ':password' => $hashed_password,
            ':ref_society' => $id_society,
            ':employee_role' => $role_name,
            ":accepted" => $accepted
        ]);
        
        $userId = $my_bdd->lastInsertId();

        // Insérer dans society_roles
        $stmt = $my_bdd->prepare("
            INSERT INTO society_roles (ref_society, ref_user, role_name) 
            VALUES (:ref_society, :ref_user, :role_name)
        ");
        $stmt->execute([
            ':ref_society' => $id_society,
            ':ref_user' => $userId,
            ':role_name' => $role_name,
        ]);

        // Envoyer l'email avec le mot de passe généré
        $subject = "Bienvenue chez SchumanConnect";
        $message = "Bonjour $prenom $nom,\n\nVotre compte a été créé avec succès.\n\nVoici vos informations de connexion :\n\nEmail : $email\nMot de passe : $plain_password\n\nMerci de changer votre mot de passe dès votre première connexion.\n\nCordialement,\nL'équipe SchumanConnect.";

        $send_email_status = send_email($email, $subject, $message);
        
        if ($send_email_status === true) {
            echo "<script>alert('Employé ajouté avec succès et un email a été envoyé à l\'utilisateur avec ses informations de connexion.');</script>";
        } else {
            echo "<script>alert('Une erreur est survenue lors de l\'envoi de l\'email.');</script>";
        }
    }
}

// Gestion de la suppression d'un employé
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    // Supprimer l'employé dans la table society_roles
    $stmt = $my_bdd->prepare("DELETE FROM society_roles WHERE ref_user = :ref_user AND ref_society = :ref_society");
    $stmt->execute([
        ':ref_user' => $delete_id,
        ':ref_society' => $id_society,
    ]);

    // Supprimer l'employé dans la table users
    $stmt = $my_bdd->prepare("DELETE FROM users WHERE id_users = :id_users AND ref_society = :ref_society");
    $stmt->execute([
        ':id_users' => $delete_id,
        ':ref_society' => $id_society,
    ]);

    echo "<script>alert('Employé supprimé avec succès.');</script>";
}

if (isset($_GET['retirer_id'])) {
    $retirer_id = (int)$_GET['retirer_id'];

    // Supprimer l'employé dans la table society_roles
    $stmt = $my_bdd->prepare("DELETE FROM society_roles WHERE ref_user = :ref_user AND ref_society = :ref_society");
    $stmt->execute([
        ':ref_user' => $retirer_id,
        ':ref_society' => $id_society,
    ]);

    // Supprimer l'employé dans la table users
    $stmt = $my_bdd->prepare("UPDATE `users` SET `ref_society`= null WHERE `id_users` = :id_users");
    $stmt->execute([
        ':id_users' => $retirer_id,
    ]);

    echo "<script>alert('Etudiant/Alumni retiré avec succès.');</script>";
}


// Récupérer la liste des employés de la société actuelle
$stmt = $my_bdd->prepare("
    SELECT u.id_users, u.prenom, u.nom, u.mail, r.role_name 
    FROM users u
    JOIN society_roles r ON u.id_users = r.ref_user
    WHERE u.ref_society = :ref_society
");
$stmt->execute([':ref_society' => $id_society]);
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour générer un mot de passe aléatoire de 12 caractères
function generate_random_password($length = 12) {
    return bin2hex(random_bytes($length / 2));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/employe.css">
    <title>Gestion des Employés</title>
</head>
<body>
<?php include_once '../../public/layouts/accueil_business_base.php'; ?> 





        <h2>Gestion des Employés</h2>
        <a href="../../view/view_business/accueil_business.php" class="back-home">Accueil</a>

        <!-- Liste des employés -->
        <h3>Liste des Employés</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($employees) > 0): ?>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($employee['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($employee['nom']); ?></td>
                            <td><?php echo htmlspecialchars($employee['mail']); ?></td>
                            <td><?php echo htmlspecialchars($employee['role_name']); ?></td>
                            <?php if(!($employee['role_name'] == 'etudiant' || $employee['role_name'] == 'alumni')) :?>
                                <td>
                                    <a href="?delete_id=<?php echo $employee['id_users']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">Supprimer</a>
                                </td>
                            <?php else : ?>
                                <td>
                                    <a href="?retirer_id=<?php echo $employee['id_users']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir retirer cet etudiant/alumni ?');">Retirer</a>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Aucun employé trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Formulaire d'ajout d'employé -->
        <h3>Ajouter un Employé</h3>
        <form method="POST" action="">
            <div>
                <label for="employee_prenom">Prénom :</label>
                <input type="text" id="employee_prenom" name="employee_prenom" required>
            </div>
            <div>
                <label for="employee_nom">Nom :</label>
                <input type="text" id="employee_nom" name="employee_nom" required>
            </div>
            <div>
                <label for="employee_email">Email :</label>
                <input type="email" id="employee_email" name="employee_email" required>
            </div>
            <div>
                <label for="employee_role">Rôle :</label>
                <select id="employee_role" name="employee_role">
                    <option value="employe">Employé</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Admin</option>
                    <option value="RH">RH</option>

                </select>
            </div>
            <button type="submit" name="add_employee">Ajouter</button>
        </form>
    </div>
</body>
</html>
