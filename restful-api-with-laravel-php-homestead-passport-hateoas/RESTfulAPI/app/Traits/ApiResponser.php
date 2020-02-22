<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

trait ApiResponser {
    
    private function successResponse($data, $code) {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code) {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200) {
        
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $collection = $this->filterData($collection);
        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        $collection = $this->cacheResponse($collection);

        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $model, $code = 200) {
        return $this->successResponse(['data' => $model], $code);
    }

    protected function showMessage($message, $code = 200) {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function sortData(Collection $collection)
    {

        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;

            $collection = $collection->sortBy($attribute)->values();
        }

        return $collection;
    }

    protected function filterData(Collection $collection) {

        foreach (request()->query as $query => $value) {
            $attribute = $query;

            if ($query == 'sort_by' || $query == 'page' || $query == 'per_page') {
                continue;
            }

            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value)->values();
            }
        }

        return $collection;

    }

    protected function paginate(Collection $collection) 
    {

        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];

        Validator::validate(request()->all(), $rules);

        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }

        $page = LengthAwarePaginator::resolveCurrentPage();

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
    
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function cacheResponse($data) 
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function() use($data) {
            return $data;
        });
    }

}

?>