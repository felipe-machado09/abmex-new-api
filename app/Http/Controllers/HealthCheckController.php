<?php

namespace App\Http\Controllers;

use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    private $status = 200;

    public function __invoke(Request $request): JsonResponse
    {
        return response()
            ->json([
                'server' => 'on',
                'db'     => $this->checkDb(),
            ]);
    }

    private function checkDb(): string
    {
        try {
            DB::connection()->getPdo();

            return 'on';
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->status = 500;

            return 'off';
        }
    }
}
