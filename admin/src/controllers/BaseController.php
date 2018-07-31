<?php

namespace Kaya\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kaya\Admin\Models\BaseModel;

class BaseController extends Controller
{
    /**
     * Table to be used for each request.
     * 
     * @var string 
     */
    protected $table;

    /**
     * Model to be used for each request.
     * 
     * @var BaseModel|Model 
     */
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return $this->model->pimp()->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get(string $table, int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    public function create(string $table, array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param array  $data
     * @return \Illuminate\Http\Response
     */
    public function update(string $table, int $id, array $data)
    {
        return $this->get($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(string $table, int $id)
    {
        return $this->get($id)->delete();
    }

    /**
     * Set the current table.
     * 
     * @return void
     */
    private function setTable () {
        $this->table = request()->table;
    }

     /**
     * Set the current model.
     * 
     * @return void
     */
    private function setModel () {
        $model = 'App\\' . str_singular(title_case($this->table));
        $this->model = class_exists($model) ? new $model : BaseModel::forTable($this->table);
    }

    /**
     * Create a new Controller for the given table.
     *
     * @return void
     */
    public function __construct() {
        $this->setTable();
        $this->setModel();
    }
}
