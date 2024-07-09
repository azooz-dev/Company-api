<?php

namespace App\Transformers\Category;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier'   => (int) $category->id,
            'title'        => (string) $category->name,
            'details'      => (string) $category->description,
            'creationDate' => (string) $category->created_at,
            'lastChange'   => (string) $category->updated_at,
            'deletedDate'  => (string) ($category->deleted_at ? $category->deleted_at : null)
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'  => 'id',
            'title'       => 'name',
            'details'     => 'description',
            'createDate'  => 'created_at',
            'lastChange'  => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
