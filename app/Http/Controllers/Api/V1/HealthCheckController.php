<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Laravel API is working',
            'app' => config('app.name'),
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
