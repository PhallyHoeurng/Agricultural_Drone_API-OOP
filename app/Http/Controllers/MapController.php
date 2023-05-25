<?php

namespace App\Http\Controllers;

use App\Http\Requests\MapRequest;
use App\Http\Resources\MapImageResource;
use App\Http\Resources\MapResource;
use App\Http\Resources\ShowMapResource;
use App\Models\Farm;
use App\Models\Map;
use Illuminate\Http\Request;

class Mapcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maps = Map::all();
        $maps = MapImageResource::collection($maps);
        return response()->json(['success' => true, 'data' => $maps], 200);
    }

    public function showall()
    {
        $maps = Map::all();
        $maps = ShowMapResource::collection($maps);
        return response()->json(['success' => true, 'data' => $maps], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(MapRequest $request)
    {
        $map = Map::store($request);
        return  response()->json(['success' => true, 'data' => $map], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // download image from farm id 
    public function downdLoadImageFarm($address ,$id)
    {
        $map = Map::where('address', $address)
        ->whereHas('farms', function ($query) use ($id) 
        {
            $query->where('id', $id);
        })->first();

        if( $map == null ){
            return response()->json(['message' => 'Address or farm not found']);
        }
            
        return response()->json(['success' => true, 'data' => $map->image_url], 200);
    }
}