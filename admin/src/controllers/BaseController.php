<?php

namespace Kaya\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kaya\Admin\Models\BaseModel;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $table
     * @return \Illuminate\Http\Response
     */
    public function all(string $table)
    {
        return BaseModel::forTable($table)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get(string $table, int $id)
    {
        return BaseModel::forTable($table)->find($id);
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param string $table
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    public function create(string $table, array $data)
    {
        return BaseModel::forTable($table)->create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $table
     * @param int $id
     * @param array  $data
     * @return \Illuminate\Http\Response
     */
    public function update(string $table, int $id, array $data)
    {
        return $this->get($table, $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $table
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(string $table, int $id)
    {
        return $this->get($table, $id)->delete();
    }
}
