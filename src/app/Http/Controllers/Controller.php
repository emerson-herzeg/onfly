<?php

namespace App\Http\Controllers;

use App\Services\ApiResponseService;

class Controller extends \Illuminate\Routing\Controller
{
    protected $apiResponse;

    public function __construct()
    {
        $this->apiResponse = app(ApiResponseService::class);
    }
}
