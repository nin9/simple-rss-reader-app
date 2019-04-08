<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Cache;

class OrderController extends Controller
{
    public function makeOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'wine_title' => 'required|string'
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $wine_title = $request->wine_title;

        $wine = Cache::get($wine_title);

        if(empty($wine)){
            return response()->json([
                'message' => 'Wine not availabe today.'
            ], 404);
        }

        return response()->json([
            'data' => $wine,
            'message' => 'Succes'
        ], 200);
    }

    public function getAvailableWines(Request $request){
        $wines = Cache::get('available_wines');
        
        if (empty($wines)){
            return response()->json([
                'message' => 'No Wines availlable today'
            ], 404);    
        }

        return response()->json([
            'data' => $wines,
            'message' => 'Succes'
        ], 200);
    }
}
