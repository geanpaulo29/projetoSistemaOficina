<?php

namespace App\Traits;

trait Filterable
{
    /**
     * Aplica filtros a uma query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyFilters($query, $filters)
    {
        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                if (is_array($value)) {
                    // Filtro para intervalo (ex: data_inicio e data_fim)
                    if (isset($value['start']) && isset($value['end'])) {
                        $query->whereBetween($field, [$value['start'], $value['end']]);
                    }
                } else {
                    // Filtro simples (ex: where 'field' like '%value%')
                    $query->where($field, 'like', "%$value%");
                }
            }
        }

        return $query;
    }

    /**
     * Aplica ordenação a uma query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sortField
     * @param string $sortDirection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applySorting($query, $sortField, $sortDirection)
    {
        if ($sortField && $sortDirection) {
            return $query->orderBy($sortField, $sortDirection);
        }

        return $query;
    }
}