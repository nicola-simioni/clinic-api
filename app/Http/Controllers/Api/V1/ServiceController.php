<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\ServiceResource;
use App\Http\Requests\Api\V1\Service\StoreRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return ServiceResource::collection($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $service = Service::create([
            "name" => $request->name,
            "description" => $request->description,
            "duration_minutes" => $request->duration_minutes,
            "price" => $request->price            
        ]);

        return response()->json(new ServiceResource($service), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {        
        return new ServiceResource($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Service $service)
    {
        $service->update([
            "name" => $request->name,
            "description" => $request->description,
            "duration_minutes" => $request->duration_minutes,
            "price" => $request->price,        
        ]);

        return new ServiceResource($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->noContent();
    }
}
