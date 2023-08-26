<?php

namespace App\Models;

use App\Helpers\SoundexHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $table = 'property';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    public function scopeFilter($query, $filters)
    {
        $name = $filters['name'] ?? null;

        
        if ($name) {
            $soundex = SoundexHelper::getSound($name);

            $query->selectRaw("property.*, word_similarity('$soundex', soundex) as sml")
                ->whereRaw("'$soundex' <% soundex")
                ->orderByDesc('sml');
        }

        if (isset($filters['bedrooms']) && $filters['bedrooms'] != '' && $filters['bedrooms'] !== null) {
            $query->where('bedrooms', (int)$filters['bedrooms']);
        }

        if (isset($filters['bathrooms']) && $filters['bathrooms'] != '' && $filters['bathrooms'] !== null) {
            $query->where('bathrooms', (int)$filters['bathrooms']);
        }

        if (isset($filters['storeys']) && $filters['storeys'] != '' && $filters['storeys'] !== null) {
            $query->where('storeys', (int)$filters['storeys']);
        }

        if (isset($filters['garages']) && $filters['garages'] != '' && $filters['garages'] !== null) {
            $query->where('garages', (int)$filters['garages']);
        }

        $price_range = $filters['price_range'] ?? '';
        $price_range = explode(',', $price_range);
        $price_from = $price_range[0] ?? null;
        $price_to = $price_range[1] ?? null;

        if ($price_from !== null && $price_to !== null) {
            $query->whereBetween('price', [$price_from, $price_to]);
        } elseif ($price_from !== null) {
            $query->where('price', '>=', $price_from);
        } elseif ($price_to !== null) {
            $query->where('price', '<=', $price_to);
        }

        return $query;

    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->soundex = SoundexHelper::getSound($model->name);
        });

        static::updating(function ($model) {
            $model->soundex = SoundexHelper::getSound($model->name);
        });
    }
}
