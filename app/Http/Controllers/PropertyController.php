<?php

namespace App\Http\Controllers;

use App\Services\Property\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        try {
            
            $property = (new PropertyService)->getAllProperties($request);

        } catch (\Exception $e) {
            return response(
                [
                    'error' => true,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ], 
                422
            );
        }

        return response(
            [
                'property' => $property,
                'error' => false,
                'message' => 'Successfully retrieved properties'
            ],
            200
        );
    }
}
