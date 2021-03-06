<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompletedStoreRequest;
use App\Http\Resources\CompletedResource;
use App\Models\Completed;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompletedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompletedResource::collection(Completed::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompletedStoreRequest $request)
    {
        $createdCompleted = Completed::create($request->validated());

        return new CompletedResource($createdCompleted);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CompletedResource(Completed::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompletedStoreRequest $request, Completed $completed)
    {
        $completed->update($request->validated());

        return new CompletedResource($completed);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Completed $completed)
    {
        $completed->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
