<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

//  findAll() qui retourne toutes les catégories
//  findOne(int $id) qui retourne la catégorie qui a l’id passé en paramètre, null si elle n’existe pas

class CategoryManager extends AbstractManager
{
    public function findAll()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($results as $row) {
            $category = new Category($row['title'], $row['description']);
            $category->setId($row['id']);
            $categories[] = $category;
        }
        return $categories;
    }

    public function findOne(int $id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $category = new Category($row['title'], $row['description']);
            $category->setId($row['id']);
            return $category;
        }
        return null;
    }
}
