<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Services\ProductServices;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductServices $ProductServices)
    {
        $data = $ProductServices->index();
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
    public function store(ProductRequest $request, ProductServices $ProductServices)
    {	
		DB::beginTransaction();
		try
		{
			$data = $ProductServices->store($request->all(), $request->File('image'));
			DB::commit();
			return $this->sendResponse(true, $data, 'Data successfully created');
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
    public function show(ProductServices $ProductServices, $id)
    {
        $data = $ProductServices->show($id);
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
    public function update(ProductRequest $request, ProductServices $ProductServices, $id)
    {
        DB::beginTransaction();
		try
		{
			$result = $ProductServices->update($id, $request->all(), $request->File('image'));
			if($result == false)
			{
				return $this->sendError('Data not found', []);
			}
			else
			{
				DB::commit();
				return $this->sendResponse(true, $result, 'Data successfully updated');
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
    public function destroy(ProductServices $ProductServices, $id)
    {
		DB::beginTransaction();
		try
		{
			$result = $ProductServices->destroy($id);
			if($result == true)
			{
				DB::commit();
				return $this->sendResponse(true, [], 'Data successfully deleted');				
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
