<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CustomDataCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (empty($attributes['data'])) {
            return [];
        }

        return json_decode($attributes['data'], true);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!empty($model->data)) {
            return ['data' => json_encode(array_merge($model->data, $value))];
        }

        return ['data' => json_encode($value)];
    }
}
