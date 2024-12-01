<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../utils/flash.php';
require __DIR__ . '../../../vendor/autoload.php';
use ConsoleTVs\Profanity\Builder;


class ForumRepository
{
    // Pour afficher tout les commentaires des commentaires d'un post
    public static function getResponseCommentaryById($idPost)
    {
        $my_bdd = Bdd::my_bdd();
        // Cette requete à été faites par moi à 80% juste une aide pour le case nouvelle notion SQL apprise et oubli de duplication de la table users
        $req_commentary_byId = $my_bdd->prepare("SELECT u.id_users,CASE WHEN u.role = 'pdg_entreprise' THEN s.nom_society  ELSE CONCAT(u.nom, ' ', u.prenom) END as user_name, p.*, rp.*, ru.id_users, ru.profile_picture FROM users AS u
        INNER JOIN reponse_post AS rp ON rp.ref_users = u.id_users
        INNER JOIN post AS p ON rp.ref_posts = p.id_post
        INNER JOIN users AS ru ON rp.ref_users = ru.id_users
        LEFT JOIN society AS s ON  u.id_users = s.ref_users
        WHERE p.id_post = ? AND rp.ref_parent_reponse IS NULL  -- Filtre les commentaires principaux (GPT c'est pour exclure les reponses de commentaires)
        ORDER by rp.id_reponse_post DESC LIMIT 3");
        $req_commentary_byId->execute([$idPost]);
        $data = $req_commentary_byId->fetchAll(PDO::FETCH_ASSOC);

        if(!$data)
            return [];
        else
            return $data;
    }

    // Pour afficher TOUT les commentaires des commentaires d'un post
    public static function getAllResponseCommentaryById($idPost)
    {
        $my_bdd = Bdd::my_bdd();
        // Cette requete à été faites par moi à 80% juste une aide pour le case nouvelle notion SQL apprise et oubli de duplication de la table users
        $req_commentary_byId = $my_bdd->prepare("SELECT u.id_users,CASE WHEN u.role = 'pdg_entreprise' THEN s.nom_society  ELSE CONCAT(u.nom, ' ', u.prenom) END as user_name, p.*, rp.*, ru.id_users, ru.profile_picture FROM users AS u
        INNER JOIN reponse_post AS rp ON rp.ref_users = u.id_users
        INNER JOIN post AS p ON rp.ref_posts = p.id_post
        INNER JOIN users AS ru ON rp.ref_users = ru.id_users
        LEFT JOIN society AS s ON  u.id_users = s.ref_users
        WHERE p.id_post = ? AND rp.ref_parent_reponse IS NULL  -- Filtre les commentaires principaux (GPT c'est pour exclure les reponses de commentaires)
        ORDER by rp.id_reponse_post DESC");
        $req_commentary_byId->execute([$idPost]);
        $data = $req_commentary_byId->fetchAll(PDO::FETCH_ASSOC);

        if(!$data)
            return [];
        else
            return $data;
    }

    public static function getResponsesByCommentId($parentCommentId)
    {
        $my_bdd = Bdd::my_bdd();

        $req_responses_by_comment = $my_bdd->prepare("
            SELECT rp.id_reponse_post, rp.text, rp.date_created, rp.ref_users, rp.ref_parent_reponse, u.id_users,
                CASE 
                    WHEN u.role = 'pdg_entreprise' THEN s.nom_society  
                    ELSE CONCAT(u.nom, ' ', u.prenom) 
                END as user_name, u.profile_picture
            FROM reponse_post rp
            INNER JOIN users u ON rp.ref_users = u.id_users
            LEFT JOIN society s ON u.id_users = s.ref_users
            WHERE rp.ref_parent_reponse = ?
            ORDER BY rp.date_created DESC
        ");
        $req_responses_by_comment->execute([$parentCommentId]);
        $responses = $req_responses_by_comment->fetchAll(PDO::FETCH_ASSOC);

        if (!$responses) {
            return []; 
        } else {
            return $responses; 
        }
    }



    public static function insertCommentaryForPost($text, $refUser, $refPost)
    {
        // Coté code API code pris d'internet l'API (Perspective) utilisée est celle de google une IA basée dans la détection de mauvais commentaire
        $my_bdd = Bdd::my_bdd();
    
        $apiKey = $_ENV['DB_API_PERSPECTIVE']; 
        $apiUrl = 'https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=' . $apiKey;

        $badwords = new Builder();

        $cleanText = $badwords->blocker($text)->filter();
        if ($cleanText !== $text) {
            return false;
        }

        $data = [
            'comment' => ['text' => $text],
            'languages' => ['fr'],  
            'requestedAttributes' => [
                'TOXICITY' => new stdClass(),
                'SEVERE_TOXICITY' => new stdClass(),
                'IDENTITY_ATTACK' => new stdClass(),
                'INSULT' => new stdClass(),
                'PROFANITY' => new stdClass()
            ]
        ];

        // Initialisation de la requête cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);

        if (isset($result['attributeScores']['TOXICITY']['summaryScore']['value']) &&
            isset($result['attributeScores']['SEVERE_TOXICITY']['summaryScore']['value'])) {
            
            $toxicity = $result['attributeScores']['TOXICITY']['summaryScore']['value'];
            $severity = $result['attributeScores']['SEVERE_TOXICITY']['summaryScore']['value'];
        
            if ($toxicity > 0.7 || $severity > 0.7) {
                return false; 
            }
        }

        try {
            $req_insert_commentary_byId = $my_bdd->prepare("INSERT INTO 
            `reponse_post`(`text`, `date_created`, `ref_users`, `ref_posts`) 
            VALUES ( ? , NOW(), ? , ?)");
            $succes = $req_insert_commentary_byId->execute([$text, $refUser, $refPost]);

            return $succes;
        } catch (Exception $e) {
            return false; 
        }
    }

    public static function insertCommentaryForResponseToPost($text, $refUser, $refPost, $parentCommentId = null)
    {
        $my_bdd = Bdd::my_bdd();
        
        $apiKey = $_ENV['DB_API_PERSPECTIVE']; 
        $apiUrl = 'https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=' . $apiKey;
    
        $badwords = new Builder();
    
        $cleanText = $badwords->blocker($text)->filter();
        if ($cleanText !== $text) {
            return false;
        }
    
        $data = [
            'comment' => ['text' => $text],
            'languages' => ['fr'],  
            'requestedAttributes' => [
                'TOXICITY' => new stdClass(),
                'SEVERE_TOXICITY' => new stdClass(),
                'IDENTITY_ATTACK' => new stdClass(),
                'INSULT' => new stdClass(),
                'PROFANITY' => new stdClass()
            ]
        ];
    
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
    
        // Décodage de la réponse JSON
        $result = json_decode($response, true);
    
        if (isset($result['attributeScores']['TOXICITY']['summaryScore']['value']) &&
            isset($result['attributeScores']['SEVERE_TOXICITY']['summaryScore']['value'])) {
            
            $toxicity = $result['attributeScores']['TOXICITY']['summaryScore']['value'];
            $severity = $result['attributeScores']['SEVERE_TOXICITY']['summaryScore']['value'];
        
            if ($toxicity > 0.7 || $severity > 0.7) {
                return false; 
            }
        }
    
        try {
            $query = "INSERT INTO 
                `reponse_post`(`text`, `date_created`, `ref_users`, `ref_posts`, `ref_parent_reponse`) 
                VALUES (?, NOW(), ?, ?, ?)";
            $stmt = $my_bdd->prepare($query);
            $stmt->execute([$text, $refUser, $refPost, $parentCommentId]);
        
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    // Pour voir si c l admin
    public static function isUserAdmin($userId)
    {
        $my_bdd = Bdd::my_bdd();
        $req_check_role = $my_bdd->prepare("SELECT `type` FROM users WHERE id_users = ?");
        $req_check_role->execute([$userId]);
        $role = $req_check_role->fetch(PDO::FETCH_ASSOC);

        return $role && $role['type'] == 1; 
    }

    public static function deleteCommentary($commentId, $userId)
    {
        $my_bdd = Bdd::my_bdd();
        $req_who_is = $my_bdd->prepare("SELECT ref_users FROM reponse_post WHERE id_reponse_post = ?");
        $req_who_is->execute([$commentId]);
        $data = $req_who_is->fetch(PDO::FETCH_ASSOC);

        if ($data && ($data['ref_users'] == $userId || self::isUserAdmin($userId))) {
            $req_delete_comment = $my_bdd->prepare("DELETE FROM reponse_post WHERE id_reponse_post = ?");
            $req_delete_comment->execute([$commentId]);
            return true;
        }
        return false; 
    }

    public static function updateCommentary($commentId, $newText, $userId)
    {

        $my_bdd = Bdd::my_bdd();
    
        $apiKey = $_ENV['DB_API_PERSPECTIVE']; 
        $apiUrl = 'https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=' . $apiKey;

        $badwords = new Builder();

        $cleanText = $badwords->blocker($newText)->filter();
        if ($cleanText !== $newText) {
            return false;
        }

        $data = [
            'comment' => ['text' => $newText],
            'languages' => ['fr'],  
            'requestedAttributes' => [
                'TOXICITY' => new stdClass(),
                'SEVERE_TOXICITY' => new stdClass(),
                'IDENTITY_ATTACK' => new stdClass(),
                'INSULT' => new stdClass(),
                'PROFANITY' => new stdClass()
            ]
        ];

        // Initialisation de la requête cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        // Décodage de la réponse JSON
        $result = json_decode($response, true);

        if (isset($result['attributeScores']['TOXICITY']['summaryScore']['value']) &&
            isset($result['attributeScores']['SEVERE_TOXICITY']['summaryScore']['value'])) {
            
            $toxicity = $result['attributeScores']['TOXICITY']['summaryScore']['value'];
            $severity = $result['attributeScores']['SEVERE_TOXICITY']['summaryScore']['value'];
        
            if ($toxicity > 0.7 || $severity > 0.7) {
                return false; 
            }
        }

        $req_who_is = $my_bdd->prepare("SELECT ref_users FROM reponse_post WHERE id_reponse_post = ?");
        $req_who_is->execute([$commentId]);
        $data = $req_who_is->fetch(PDO::FETCH_ASSOC);

        if ($data && ($data['ref_users'] == $userId || self::isUserAdmin($userId))) {
            $req_update_comment = $my_bdd->prepare("UPDATE reponse_post SET text = ? WHERE id_reponse_post = ?");
            $req_update_comment->execute([$newText, $commentId]);
            return true;
        }
        return false; 
    }

    // Fonction pour récupérer tous les commentaires et leurs réponses d'un utilisateur
    public static function getUserCommentsAndResponses($userId)
    {
        $my_bdd = Bdd::my_bdd();

        // Récupérer tous les commentaires principaux de l'utilisateur
        $req_comments = $my_bdd->prepare("
            SELECT u.id_users, 
                CASE WHEN u.role = 'pdg_entreprise' THEN s.nom_society  
                    ELSE CONCAT(u.nom, ' ', u.prenom) 
                END AS user_name, 
                p.*, rp.*, ru.id_users AS response_user_id, 
                ru.profile_picture 
            FROM users AS u
            INNER JOIN reponse_post AS rp ON rp.ref_users = u.id_users
            INNER JOIN post AS p ON rp.ref_posts = p.id_post
            LEFT JOIN society AS s ON u.id_users = s.ref_users
            INNER JOIN users AS ru ON rp.ref_users = ru.id_users
            WHERE rp.ref_users = ?
            ORDER BY rp.id_reponse_post DESC
        ");
        $req_comments->execute([$userId]);
        $comments = $req_comments->fetchAll(PDO::FETCH_ASSOC);

        // Pour chaque commentaire, récupérer les réponses
        foreach ($comments as &$comment) {
            $comment['responses'] = self::getResponsesByCommentId($comment['id_reponse_post']);
        }

        return $comments;
    }


    // Fonction pour récupérer tous les commentaires et leurs réponses d'un utilisateur QUI a répondu à un commentaire 
    public static function getResponsesByCommentIde($parentCommentId, $userId)
    {
        $my_bdd = Bdd::my_bdd();

        $req_responses_by_comment = $my_bdd->prepare("
            SELECT 
                rp.id_reponse_post, 
                rp.text, 
                rp.date_created, 
                rp.ref_users, 
                rp.ref_parent_reponse, 
                u.id_users,
                CASE 
                    WHEN u.role = 'pdg_entreprise' THEN s.nom_society  
                    ELSE CONCAT(u.nom, ' ', u.prenom) 
                END as user_name, 
                u.profile_picture,
                p.title AS original_post_title, -- Ajouter le titre du post d'origine
                p2.text AS parent_comment_text  -- Le commentaire parent, s'il existe
            FROM reponse_post rp
            INNER JOIN users u ON rp.ref_users = u.id_users
            LEFT JOIN society s ON u.id_users = s.ref_users
            INNER JOIN post p ON rp.ref_posts = p.id_post  
            LEFT JOIN reponse_post p2 ON p2.id_reponse_post = rp.ref_parent_reponse 
            WHERE (rp.ref_parent_reponse = ? OR rp.ref_users = ?) -- Inclure vos propres réponses
            ORDER BY rp.date_created DESC
        ");
        $req_responses_by_comment->execute([$parentCommentId, $userId]);
        $responses = $req_responses_by_comment->fetchAll(PDO::FETCH_ASSOC);

        return $responses ?: [];
    }

    // BON ici une aide à été requise pour pouvoir séparer les commentaires d'un post et les commentaires d'une reponse à un commentaire pour que ça soit claire et conscis
    public static function getUserCommentsAndResponsesSeparated($userId)
    {
        $my_bdd = Bdd::my_bdd();

        // Récupérer les commentaires de l'utilisateur (faits sur des posts originaux)
        $commentsQuery = "
            SELECT p.id_post, rp.id_reponse_post, rp.text, rp.date_created, p.title AS post_title, rp.ref_parent_reponse, NULL AS parent_comment_text
            FROM reponse_post rp
            INNER JOIN post p ON rp.ref_posts = p.id_post
            WHERE rp.ref_users = :user_id AND rp.ref_parent_reponse IS NULL
            ORDER BY rp.date_created DESC";

        // Récupérer les réponses de l'utilisateur (faits en réponse à des commentaires)
        $responsesQuery = "
            SELECT p.id_post, rp.id_reponse_post, rp.text, rp.date_created, rp.ref_parent_reponse, p.title AS post_title, parent_rp.text AS parent_comment_text
            FROM reponse_post rp
            INNER JOIN reponse_post parent_rp ON rp.ref_parent_reponse = parent_rp.id_reponse_post
            INNER JOIN post p ON rp.ref_posts = p.id_post
            WHERE rp.ref_users = :user_id
            ORDER BY rp.date_created DESC";

        // Exécution des deux requêtes
        $commentsStmt = $my_bdd->prepare($commentsQuery);
        $commentsStmt->execute(['user_id' => $userId]);
        $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

        $responsesStmt = $my_bdd->prepare($responsesQuery);
        $responsesStmt->execute(['user_id' => $userId]);
        $responses = $responsesStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'comments' => $comments,
            'responses' => $responses
        ];
    }

    public static function getTotalCommentsByPostId($postId)
    {
        $my_bdd = Bdd::my_bdd();
        $req_sql = "
            SELECT COUNT(*) AS total FROM reponse_post 
            WHERE ref_posts = ? AND ref_parent_reponse IS NULL
        ";
        $req_nb_comments = $my_bdd->prepare($req_sql);
        $req_nb_comments->execute([$postId]);
        $result = $req_nb_comments->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public static function incrementViewCountByPostId($postId)
    {
        $my_bdd = Bdd::my_bdd();
        
        $req_sql = "UPDATE post SET view_post = view_post + 1 WHERE id_post = ?";
        $req_update_views = $my_bdd->prepare($req_sql);
        $req_update_views->execute([$postId]);
    }
}
?>