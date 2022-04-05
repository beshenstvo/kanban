<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InProcessStoreRequest;
use App\Http\Resources\InProcessResource;
use App\Models\InProcess;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InProcessResource::collection(InProcess::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InProcessStoreRequest $request)
    {
        $createdInProcces = InProcess::create($request->validated());

        return new InProcessResource($createdInProcces);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  new InProcessResource(InProcess::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InProcessStoreRequest $request, InProcess $inProcess)
    {
        $inProcess->update($request->validated());

        return new InProcessResource($inProcess);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InProcess $inProcess)
    {
        $inProcess->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
