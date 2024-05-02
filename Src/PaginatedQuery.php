<?php

namespace App;

use Exception;
use PDO;

class PaginatedQuery 
{
    private $query;
    private $queryCount;
    private $pdo;
    private $perPage;
    private $items;

    public function __construct(
        string $query,
        string $queryCount,
        ?PDO $pdo = null,
        int $perPage = 12

    )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }
    
    public function getItems (string $classMaping): array
    {
        if ($this->items === null)
        {
            $currentPage = $this->getCurrentPage();
            $pages = $this->getPages();
            if ($currentPage > $pages)
            {
                throw new Exception("Cette page n'existe pas");
            }
            $offset = $this->perPage * ($currentPage - 1);

            $req2 = $this->query . " LIMIT {$this->perPage} OFFSET $offset";
            $stmt2 = $this->pdo->prepare($req2);
            $stmt2->execute();
            $stmt2->setFetchMode(PDO::FETCH_CLASS, $classMaping);
            $this->items = $stmt2->fetchAll();
        }
        return $this->items;
    }

    public function previousLink (string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage <= 1) return null;
        if($currentPage > 2) $link .= "?page=" . ($currentPage - 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-primary">&laquo; Page Précédente</a>
HTML;
    }

    public function nextLink (string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if ($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-primary">Page Suivante&raquo; </a>
HTML;
    }

    private function getCurrentPage (): int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getPages (): int
    {
        $req1 = $this->queryCount;
        $stmt1 = $this->pdo->prepare($req1);
        $stmt1->execute();
        $count = (int)$stmt1->fetch(PDO::FETCH_NUM)[0];
        return ceil($count / $this->perPage);
    }

}

