<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasDataTable
{
    /**
     * Process DataTable request
     *
     * @param Builder $query Base query
     * @param array $searchColumns Columns to search in
     * @param array $allowedSorts Allowed sort columns
     * @param array $allowedFilters Custom filters configuration
     * @param string $defaultSort Default sort column
     * @param string $defaultDirection Default sort direction
     */
    protected function dataTable(
        Builder $query,
        array $searchColumns = [],
        array $allowedSorts = [],
        array $allowedFilters = [],
        string $defaultSort = 'created_at',
        string $defaultDirection = 'desc'
    ) {
        $request = request();

        // Apply search
        if ($request->filled('search') && !empty($searchColumns)) {
            $query->where(function ($q) use ($request, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $request->search . '%');
                }
            });
        }

        // Apply custom filters
        foreach ($allowedFilters as $filterKey => $filterConfig) {
            if ($request->filled($filterKey)) {
                $this->applyFilter($query, $filterKey, $filterConfig, $request->get($filterKey));
            }
        }

        // Apply sorting
        $sortField = $request->get('sort', $defaultSort);
        $sortDirection = $request->get('direction', $defaultDirection);

        // Validate sort field
        if (!empty($allowedSorts) && !in_array($sortField, $allowedSorts)) {
            $sortField = $defaultSort;
        }

        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = $defaultDirection;
        }

        $query->orderBy($sortField, $sortDirection);

        // Handle pagination or return all
        if ($request->get('all') === 'true') {
            return $this->getAllData($query);
        }

        return $query->paginate($request->get('per_page', 10))
            ->withQueryString();
    }

    /**
     * Apply custom filter to query
     */
    protected function applyFilter(Builder $query, string $filterKey, $filterConfig, $value)
    {
        // If config is a closure, use it
        if (is_callable($filterConfig)) {
            $filterConfig($query, $value);
            return;
        }

        // If config is array with type
        if (is_array($filterConfig)) {
            $type = $filterConfig['type'] ?? 'equals';
            $column = $filterConfig['column'] ?? $filterKey;

            switch ($type) {
                case 'equals':
                    $query->where($column, $value);
                    break;

                case 'like':
                    $query->where($column, 'like', '%' . $value . '%');
                    break;

                case 'relationship':
                    $relationship = $filterConfig['relationship'];
                    $relationColumn = $filterConfig['relation_column'] ?? 'id';
                    $query->whereHas($relationship, function ($q) use ($relationColumn, $value) {
                        $q->where($relationColumn, $value);
                    });
                    break;

                case 'date_range':
                    if (is_array($value) && count($value) === 2) {
                        $query->whereBetween($column, [$value[0], $value[1]]);
                    }
                    break;

                case 'boolean':
                    $query->where($column, filter_var($value, FILTER_VALIDATE_BOOLEAN));
                    break;
            }
        }
    }

    /**
     * Get all data formatted for client-side pagination
     */
    protected function getAllData(Builder $query)
    {
        $data = $query->get();

        return [
            'data' => $data,
            'current_page' => 1,
            'last_page' => 1,
            'per_page' => $data->count(),
            'total' => $data->count(),
            'from' => 1,
            'to' => $data->count(),
        ];
    }

    /**
     * Get filters from request
     */
    protected function getFilters(array $additionalFilters = []): array
    {
        $defaultFilters = ['search', 'sort', 'direction', 'per_page'];
        $allFilters = array_merge($defaultFilters, $additionalFilters);

        return request()->only($allFilters);
    }
}
