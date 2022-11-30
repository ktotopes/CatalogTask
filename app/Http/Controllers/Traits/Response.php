<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;

trait Response {
    public function jsonSuccess($data = [], int $status = 200): JsonResponse
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        $data = collect(['success' => true])->merge(compact('data'));

        return response()->json($data, $status);
    }

    public function jsonError(iterable $data = [], int $status = 400, iterable $errors = [], $message = ''): JsonResponse
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        $data = collect(['success' => false])->merge(compact('data'))->merge(compact('errors'));

        $data['message'] = $message;

        return response()->json($data, $status);
    }

}
