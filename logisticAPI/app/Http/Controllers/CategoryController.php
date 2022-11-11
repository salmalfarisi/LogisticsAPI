<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryServices;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryServices $CategoryServices)
    {
        $data = $CategoryServices->index();
		return $this->sendResponse(true, $data, 'Index data');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request, CategoryServices $CategoryServices)
    {	
		DB::beginTransaction();
		try
		{
			$CategoryServices->store($request->all());
			DB::commit();
			return $this->sendResponse(true, $request->all(), 'Data successfully created');
		}
		catch(Throwable $e)
		{
			DB::rollback();
			return $this->handlingErrorCatch($e);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryServices $CategoryServices, $id)
    {
        $data = $CategoryServices->show($id);
		return $this->sendResponse(true, $data, 'Detail data');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, CategoryServices $CategoryServices, $id)
    {
        DB::beginTransaction();
		try
		{
			$result = $CategoryServices->update($id, $request->all());
			if($result == false)
			{
				return $this->sendError('Data not found', []);
			}
			else
			{
				DB::commit();
				return $this->sendResponse(true, $request->all(), 'Data successfully updated');
			}
		}
		catch(Throwable $e)
		{
			DB::rollback();
			return $this->handlingErrorCatch($e);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryServices $CategoryServices, $id)
    {
		DB::beginTransaction();
		try
		{
			$result = $CategoryServices->destroy($id);
			if($result == true)
			{
				DB::commit();
				return $this->sendResponse(true, [], 'Data successfully updated');				
			}
			else
			{
				return $this->sendError('Data not found', []);
			}
		}
		catch(Throwable $e)
		{
			DB::rollback();
			return $this->handlingErrorCatch($e);
		}
    }
}
