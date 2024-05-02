<?php

namespace App\Models;

use App\Helper;
use App\Helpers\Text;
use DateTime;

class Post
{
    private $id;

    private $name;

    private $slug;

    private $content;

    private $created_at;

    private $categories = [];


    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of slug
     */ 
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getFormattedContent(): ?string
    {
        return nl2br(Helper::e($this->content));
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getExcerpt (): ?string
    {
        if ($this->content === null)
        {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content)));
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function setCreatedAt(string $date): self
    {
        $this->created_at = $date;

        return $this;
    }

    /**
     * Tableau de Categories
     *
     * @return Category[]
     */
    public function getCategories (): array
    {
        return $this->categories;
    }

    public function addCategory (Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

}