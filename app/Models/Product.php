<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; 
    protected $table = 'products';

    protected $fillable = [
        'product_title', 
        'product_description', 
        'product_image', 
        'color_ids',
        'size_ids',
    ];

    protected $casts = [
        'color_ids' => 'array',
        'size_ids' => 'array',
    ];

    /**
     * Mutator to set color ids attribute.
     */
    public function setColorIdsAttribute($value)
    {
        $this->attributes['color_ids'] = json_encode($value);
    }

    /**
     * Accessor to get color ids attribute.
     */
    public function getColorIdsAttribute($value)
    {
        return json_decode($value);
    }


    /**
     * Mutator to set size ids attribute.
     */
    public function setSizeIdsAttribute($value)
    {
        $this->attributes['size_ids'] = json_encode($value);
    }

    /**
     * Accessor to get size ids attribute.
     */
    public function getSizeIdsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get the colors associated with the product.
     */
    // public function colors()
    // {
    //     return $this->belongsToMany(Color::class);
    // }

    // /**
    //  * Get the sizes associated with the product.
    //  */
    // public function sizes()
    // {
    //     return $this->belongsToMany(Size::class);
    // }

    /**
     * Scope to fetch color IDs and names.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    /**
 * Scope to fetch color IDs and names.
 *
 * @param \Illuminate\Database\Eloquent\Builder $query
 * @return \Illuminate\Database\Eloquent\Builder
 */
// public function scopeWithColors($query)
// {
//     return $query->select('products.*')
//                  ->selectRaw("JSON_ARRAYAGG(colors.id) as color_ids")
//                  ->selectRaw("JSON_ARRAYAGG(colors.name) as color_names")
//                  ->leftJoin('colors', function ($join) {
//                      $join->whereIn('colors.id', $this->color_ids);
//                  })
//                  ->groupBy('products.id');
// }

}
