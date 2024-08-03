<?php 

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

trait ApiResponser {
    private function successResponse($data, $code) {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code) {
        return response()->json(['error' => $message], $code);
    }

    protected function showAll(JsonResource $collection, $code = 200) {
        if ($collection->isEmpty()) {
            return $this->successResponse($collection, $code);
        }
        $transformer = get_class($collection->first());

        $collection = $this->pagination(new Collection($this->filterData(new Collection($this->sortData(new Collection($collection), $transformer)), $transformer)));
        $collection = $this->cacheResponse($collection);
        return $this->successResponse($collection, $code);
    }


    protected function showOne(JsonResource $instance, $code = 200) {
        return response()->json(['data' => $instance], $code);
    }

    protected function showMessage(string $message, $code = 200) {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function sortData(Collection $collection, $transformer) {
        if (request()->has('sort_by')) {
            $attribute = $transformer::transformAttribute(request()->sort_by);

            $collection = $collection->sortBy($attribute);
        }
        return $collection;
    }

    protected function pagination(Collection $collection) {
        request()->validate([
            'per_page' => 'integer|min:2|max:50',
        ]);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;

        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }
        $result = $collection->slice(($page - 1) * $perPage, $perPage);
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function filterData(Collection $collection, $transformer) {

        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::transformAttribute($query);

            if (isset($attribute)) {
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection->values();
    }

    protected function cacheResponse($data) {
        // Get the current URL
        $url = request()->url();

        // Get the query parameters and sort them
        $queryParams = request()->query();
        ksort($queryParams);

        // Build the query string
        $queryString = http_build_query($queryParams);

        // Create the full URL with query string
        $fullUrl = $url . '?' . $queryString;

        // Set the cache time
        $time = 60; // 1 minute

        // Return the cached data or generate it if it doesn't exist
        return Cache::remember($fullUrl, $time, function () use ($data) {
            return $data;
        });
    }
}