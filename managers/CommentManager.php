<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

//  findByPost(int $postId) qui retourne les commentaires ayant le post dont l’id est passé en paramètre
//  create(Comment $comment) qui insère le commentaire passé en paramètres dans la base de données
class CommentManager extends AbstractManager
{



    public function  findByPost(int $postId): array
    {

        $query = 'SELECT comments.*, posts.id AS post_id
        FROM comments
        JOIN posts ON comments.post_id= posts.id
        WHERE posts.id = :postId
        ORDER BY posts.created_at DESC';

        $stmt = $this->db->prepare($query);
        $stmt->execute(['postId' => $postId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $comments = [];

        $userManager = new UserManager();
        $postManager = new PostManager();

        foreach ($results as $result) {

            $user = $userManager->findOne($result['user_id']);
            $post = $postManager->findOne($result['post_id']);

            $comment = new Comment($result['content'], $user, $post);
            $comment->setId($result['id']);

            $comments[] = $comment;
        }

        return $comments;
    }



    //  create(Comment $comment) qui insère le commentaire passé en paramètres dans la base de données

    public function create(Comment $comment): bool
    {
        $query = 'INSERT INTO comments (content, user_id, post_id) VALUES (:content, :user_id, :post_id)';
        $stmt = $this->db->prepare($query);

        $parameters = [
            'content' => htmlspecialchars($comment->getContent()), //securité
            'user_id' => htmlspecialchars($comment->getUser()->getId()), //securité
            'post_id' => htmlspecialchars($comment->getPost()->getId()), // securité
        ];


        $result = $stmt->execute($parameters);

        if ($result) {
            $comment->setId((int)$this->db->lastInsertId());
        }

        return $result;
    }
}
