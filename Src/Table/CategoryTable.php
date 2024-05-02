<?php

namespace App\Table;

use App\Models\Category;
use Exception;
use PDO;

final class CategoryTable extends Table
{

    protected $table = "category";
    protected $class = Category::class;

    /**
     *
     * @param App\Model\Post[] $posts
     * @return void
     */
    public function hydratePosts (array $posts): void
    {
        $postByID = [];
         foreach($posts as $post)
         {
             $postByID[$post->getId()] = $post;
         }
         $categories = $this->pdo
             ->query('SELECT c.*, pc.post_id
                      FROM post_category pc
                      JOIN category c ON c.id = pc.category_id
                      WHERE pc.post_id IN (' .implode(',', array_keys($postByID)). ')'
             )->fetchAll(PDO::FETCH_CLASS, Category::class);
         
         foreach ($categories as $category)
         {
             $postByID[$category->getPostId()]->addCategory($category);
         }
    }

    public function create (Category $category): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name = :name, slug = :slug");
        $ok =  $query->execute([
            'name'    => $category->getName(),
            'slug'    => $category->getSlug(),
        ]);
        if ($ok === false)
        {
            throw new Exception("Impossible de d'éffectuer l'enrégistrement dans la table {$this->table}");
        }
        $category->setId($this->pdo->lastInsertId());
    }

    public function update (Category $category): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug  WHERE id = :id");
        $ok =  $query->execute([
            'id'      => $category->getId(),
            'name'    => $category->getName(),
            'slug'    => $category->getSlug()
        ]);
        if ($ok === false)
        {
            throw new Exception("Impossible de modifier l'enrégistrement {$category->getId()} dans la table {$this->table}");
        }
    }

    public function delete (int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok =  $query->execute([$id]);
        if ($ok === false)
        {
            throw new Exception("Impossible de supprimer l'enrégistrement $id dans la table {$this->table}");
        }
    }

}