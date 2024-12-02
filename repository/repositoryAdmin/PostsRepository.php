<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';

class PostsRepository {
    public static function getPostsNumber() {
        $bdd = Bdd::my_bdd();
        $count = $bdd->prepare("SELECT COUNT(*) as nbPosts FROM post;");
        $count->execute();
        $nbPosts = $count->fetch();
        return $nbPosts["nbPosts"];
    }

    public static function getPosts() {
        $bdd = Bdd::my_bdd();
        $selection = $bdd->prepare("SELECT * FROM post;");
        $selection->execute();
        return $selection->fetchAll();
    }

    public static function getPostById($id) {
        $bdd = Bdd::my_bdd();
        $post = $bdd->prepare("SELECT * FROM post WHERE id_post = :id;");
        $post->execute(array(
            "id" => $id
        ));
        return $post->fetch();
    }

    public static function updatePost($id, $title, $description, $image_video = null) {
        $bdd = Bdd::my_bdd();

        if ($image_video !== null) {
            $update = $bdd->prepare("UPDATE post SET title = :title, description = :description, image_video = :image_video WHERE id_post = :id;");
            $update->execute(array(
                "id" => $id,
                "title" => $title,
                "description" => $description,
                "image_video" => $image_video
            ));
        }
        else {
            $update = $bdd->prepare("UPDATE post SET title = :title, description = :description WHERE id_post = :id;");
            $update->execute(array(
                "id" => $id,
                "title" => $title,
                "description" => $description
            ));
        }
    }

    public static function deletePost($id) {
        $bdd = Bdd::my_bdd();
        $delete = $bdd->prepare("DELETE FROM post WHERE id_post = :id;");
        $delete->execute(array(
            "id" => $id
        ));
    }
}
