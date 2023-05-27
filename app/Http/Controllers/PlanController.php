<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanStoreRequest;
use App\Http\Resources\PlanResource;
use App\Http\Resources\PlanShowResource;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plan = Plan::all();
        $plan = PlanResource::collection($plan);
        return response()->json(['success' => true, 'data' => $plan], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanStoreRequest $request)
    {
        $plan = Plan::store($request);
        return response()->json(['success' => true, 'data' => $plan], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $plan = Plan::find($name);
        $plan = new PlanShowResource($plan);
        return response()->json(['success' => true, 'data' => $plan], 201);
    }

    public function showplan(string $name)
    {
        $plan = Plan::where('plan_name', $name)->with('drones')->first();
        
        if (!$plan) {
            return response()->json(['plan not found' => $plan],404);
        }
        return $plan;
    }
}
