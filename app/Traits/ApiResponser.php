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
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $model, $code = 200) {
        return response()->json(['data' => $model], $code);
    }

}