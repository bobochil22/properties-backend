<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Class JsonEntity
 * @package App\Helpers\JsonEntity
 *
 * @property Collection $items
 */
class JsonEntity
{
    public $filePath;

    protected $primaryKey = 'id';

    private $items;

    public function __construct($attributes = [])
    {
        if(isset($this->filePath))
            $this->setItems();

        $this->fill($attributes);
    }

    public function setItems()
    {
        $this->items = collect($this->parseJson(Storage::get($this->filePath)))->map(function ($item) {
            return (object)$item;
        });
    }

    protected function parseJson(string $jsonString)
    {
        $sanitizedJsonString = substr_replace($jsonString,"",0,3);
        /** Fixes JSON first 3 non UTF characters */

        if(json_decode($sanitizedJsonString)){
            $jsonString=$sanitizedJsonString;
        }
        return (json_decode($jsonString));
    }

    public function fill($attributes)
    {
        foreach ($attributes as $k => $attribute)
            $this->$k = $attribute;
    }

    public function all()
    {
        return $this->items;
    }

    public function find($value)
    {
        $item = $this->where($this->primaryKey, '=', $value)->first();
        return new $this($item ?? []);
    }

    public function where(string $name, string $operator = null, string $value = null): Collection
    {
        return $this->items->where($name, $operator, $value);
    }
}
