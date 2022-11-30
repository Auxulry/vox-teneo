<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\Http\HasApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    use HasApiResponse;

    public function welcome(): JsonResponse
    {
        return $this->setResponse(Response::HTTP_OK, 'Welcome to Vox Teneo');
    }
}
