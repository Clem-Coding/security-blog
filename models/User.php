<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class User
{
    private ?int $id = null;

    // Les paramètres email et password ont maintenant des valeurs par défaut vides (''). 
    // Si on ne passe pas ces arguments lors de l'instanciation de la classe, PHP utilisera automatiquement ces valeurs.
    public function __construct(
        private string $username,
        private string $email = '',       // Email par défaut vide,
        private string $password = '',    // Mot de passe par défaut vide
        private string $role = '',
        private DateTime $createdAt = new DateTime() // On assigner une valeur par défaut (comme la date/heure actuelle). 
    ) {}
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
