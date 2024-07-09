<?php 

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser {
    private function successResponse($data, $code) {
        return response()->json($data, $code);
    }


    protected function errorResponse($message, $code) {
        return response()->json(['error' => $message], $code);
    }


    protected function showAll(Collection $collection, $code = 200) {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        $transformer = $collection->first()->transformer;

        $collection  = $this->transformData($this->sortData($this->filterData($collection, $transformer), $transformer), $transformer);
        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200) {
        $transformer = $instance->transformer;

        $instance = $this->transformData($instance, $transformer);
        return response()->json($instance, $code);
    }

    protected function showMessage(string $message, $code = 200) {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformData($data, $transformer) {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function sortData($collection, $transformer) {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttribute(request()->sort_by);

            $collection = $collection->sortBy($attribute);
        }

        return $collection;
    }

    protected function filterData($collection, $transformer) {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttribute($query);

            if (isset($attribute)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }
}