<?php

namespace App\Table;

use App\Models\Post;
use App\PaginatedQuery;
use Exception;

final class PostTable extends Table
{

    protected $table = "post";
    protected $class = Post::class;

    public function create (Post $post): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name = :name, slug = :slug, created_at = :created, content = :content");
        $ok =  $query->execute([
            'name'    => $post->getName(),
            'slug'    => $post->getSlug(),
            'content' => $post->getContent(),
            'created' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        if ($ok === false)
        {
            throw new Exception("Impossible de d'éffectuer l'enrégistrement dans la table {$this->table}");
        }
        $post->setId($this->pdo->lastInsertId());
    }

    public function update (Post $post): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug, created_at = :created, content = :content  WHERE id = :id");
        $ok =  $query->execute([
            'id'      => $post->getId(),
            'name'    => $post->getName(),
            'slug'    => $post->getSlug(),
            'content' => $post->getContent(),
            'created' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        if ($ok === false)
        {
            throw new Exception("Impossible de modifier l'enrégistrement {$post->getId()} dans la table {$this->table}");
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

    public function findPaginated ()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT count(id) FROM post",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems (Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory (int $categoryID)
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.* 
             FROM post p
             JOIN post_category pc ON pc.post_id = p.id
             WHERE pc.category_id = {$categoryID}
             ORDER BY created_at DESC",
            "SELECT count(category_id) FROM post_category WHERE category_id = {$categoryID}",
        );
         
        /** @var Post[] */
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

}