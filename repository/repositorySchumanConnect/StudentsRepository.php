<?php
include '../../utils/Bdd.php';

class StudentsRepository
{
     public function searchStudents($search_term, $filters = [])
     {
          $my_bdd = Bdd::my_bdd();

          try 
          {
               $query = 'SELECT * FROM users WHERE (prenom LIKE :search OR nom LIKE :search)';

               // Options de filtrage (chatGPT)
               if (!empty($filters['formation'])) 
               {
                    $query .= ' AND promo IN (' . implode(',', array_map(function ($f) { return '"' . $f . '"'; }, $filters['formation'])) . ')';
               }
               if (!empty($filters['role'])) 
               {
                    $query .= ' AND  `role` IN (' . implode(',', array_map(function ($s) { return '"' . $s . '"'; }, $filters['role'])) . ')';
               }
               if (!empty($filters['level'])) 
               {
                    $query .= ' AND  `level` IN (' . implode(',', array_map(function ($p) { return '"' . $p . '"'; }, $filters['level'])) . ')';
               }

               $query .= ' ORDER BY id_users DESC'; 

               $req_select_students = $my_bdd->prepare($query);
               $req_select_students->execute(['search' => '%' . $search_term . '%']);
               $students = $req_select_students->fetchAll(PDO::FETCH_ASSOC);

               return $students;
          } 
          catch (PDOException $e) 
          {
               echo "Erreur PDO : " . $e->getMessage();
               return [];
          }
     }

     public function getAllStudents() 
     {
          
          $my_bdd = Bdd::my_bdd();

          $sql = $my_bdd->prepare("SELECT * FROM users");
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