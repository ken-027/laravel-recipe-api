<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HealthCheckController extends Controller
{
    /**
     * Health check
     */
    public function __invoke(Request $request)
    {
        try {

            Artisan::call('db:monitor');

            return response()->json([
                'status' => 'up',
                'services' => [
                    'database' => 'up',
                    'postgresql' => 'up',
                ],
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'down',
                'services' => [
                    'database' => 'down',
                    'postgresql' => $ex->getMessage(),
                ],
            ], 500);
        }
    }
}
