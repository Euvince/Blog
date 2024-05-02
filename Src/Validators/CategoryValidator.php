<?php 

namespace App\Validators;

use App\Table\CategoryTable;

class CategoryValidator extends AbstractValidator
{
    public function __construct(array $data, CategoryTable $table,)
    {
        parent::__construct($data);
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function ($field, $value) use ($table){
            return !$table->exists($field, $value);
        }, ['slug', 'name'], 'est déjà utilisé');
        $this->validator->labels([
            'name'    => 'Le Titre',
            'content' => 'Le Contenu',
            'slug'    => 'Le Slug'
        ]);
    }

}