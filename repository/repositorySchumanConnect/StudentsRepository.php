<?php
include '../../utils/Bdd.php';

class StudentsRepository
{
     public function searchStudents($search_term, $filters = [])
     {
          $my_bdd = Bdd::my_bdd();

          try {
               $query = 'SELECT * FROM users WHERE (prenom LIKE :search OR nom LIKE :search) AND (`accepted` = 1 AND (`type` = 0 OR `type` IS NULL))';

                    // Options de filtrage (chatGPT)
                    $params = ['search' => '%' . $search_term . '%'];

               if (!empty($filters['formation'])) {
                    $placeholders = [];
                    foreach ($filters['formation'] as $key => $value) {
                         $placeholder = ':formation_' . $key;
                         $placeholders[] = $placeholder;
                         $params[$placeholder] = $value;
                    }
                    $query .= ' AND promo IN (' . implode(',', $placeholders) . ')';
               }

               if (!empty($filters['role'])) {
                    $placeholders = [];
                    foreach ($filters['role'] as $key => $value) {
                         $placeholder = ':role_' . $key;
                         $placeholders[] = $placeholder;
                         $params[$placeholder] = $value;
                    }
                    $query .= ' AND `role` IN (' . implode(',', $placeholders) . ')';
               }

               if (!empty($filters['level'])) {
                    $placeholders = [];
                    foreach ($filters['level'] as $key => $value) {
                         $placeholder = ':level_' . $key;
                         $placeholders[] = $placeholder;
                         $params[$placeholder] = $value;
                    }
                    $query .= ' AND `level` IN (' . implode(',', $placeholders) . ')';
               }

               $query .= ' ORDER BY id_users DESC';

               $req_select_students = $my_bdd->prepare($query);
               $req_select_students->execute($params);
               return $req_select_students->fetchAll(PDO::FETCH_ASSOC);

          } catch (PDOException $e) {
               echo "Erreur PDO : " . $e->getMessage();
               return [];
          }
     }

     public function getAllStudents() 
     {
          
          $my_bdd = Bdd::my_bdd();

          $sql = $my_bdd->prepare("SELECT * FROM users WHERE accepted = 1 AND (`type` = 0 OR `type` IS NULL)");
          $sql->execute();
          return $sql->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getStudentById($id)
     {
          $my_bdd = Bdd::my_bdd();

          $req_by_id = $my_bdd->prepare('SELECT * FROM users WHERE id_users = :id_users');
          $req_by_id->execute(array(
               'id_users' => $id
          ));
          return $req_by_id->fetch(PDO::FETCH_ASSOC);
     }

     // Fonction pour afficher les etudiant
     public static function find_students()
     {
  
     }
 
     // Fonction pour supprimer un etudiant
     public static function delete_students()
     {
 
     }
 
     // Fonction pour modifier un etudiant
     public static function update_students()
     {
 
     }
     // Fonction pour inserer un etudiant
     public static function insert_students()
     {
 
     }
}