<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

//  findByEmail(string $email) qui retourne le user qui a l’email passé en paramètre, null si il n’existe pas
//  create(User $user) qui insère l’utilisateur passé en paramètres dans la base de données
class UserManager extends AbstractManager
{


    public function findOne(int $id): ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $parameters = ['id' => $id];
        $query->execute($parameters);
        $data = $query->fetch();

        if ($data) {
            $user = new User(
                $data["username"],
                $data["email"],
                $data["password"],
                $data["role"],
                new DateTime($data['created_at']),
            );
            $user->setId($data['id']);
            return $user;
        }

        return null;
    }

    public function findByEmail(string $email): ?User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new User(
                $data['username'],
                $data['email'],
                $data['password'],
                $data['role'],
                new DateTime($data['created_at'])
            );
            $user->setId($data['id']);
            return $user;
        } else {
            return null;
        }
    }


    public function create(User $user): void
    {
        $query = $this->db->prepare('INSERT INTO users (username, email, password, role, created_At) VALUES (:username, :email, :password, :role,:created_At)');


        $parameters = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
            'created_At' => $user->getCreatedAt()->format('Y-m-d H:i:s'),

        ];

        $query->execute($parameters);
        $user->setId($this->db->lastInsertId());
    }
}
