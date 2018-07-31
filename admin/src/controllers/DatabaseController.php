<?php

namespace Kaya\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kaya\Admin\Models\BaseModel;

class DatabaseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return array_map(function ($table) {
            return [
                'name' => [
                    'original' => $table,
                    'plural' => static::properPluralName($table),
                    'singular' => static::properSingularName($table)
                ],
                'model' => static::model($table),
            ];
        }, static::tables());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get(string $table)
    {
        return request()->visualization ? static::cleanColumns($table) : static::columns($table);
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
     * This function removes '_id' and '_' from the name of a string.
     *
     * @param string
     * @return string
     */
    private static function cleanName(string $name)
    {
        return str_replace('_', ' ', str_replace('_id', '', $name));
    }

     /**
     * This function returns a singular proper name for a given string.
     *
     * @param string
     * @return string
     */
    private static function properSingularName(string $name)
    {
        return str_singular(static::properName($name));
    }

    /**
     * This function returns a plural proper name for a given string.
     *
     * @param string
     * @return string
     */
    private static function properPluralName(string $name)
    {
        return str_plural(static::properName($name));
    }

    /**
     * This function returns a proper name for a given string.
     *
     * @param string
     * @return string
     */
    private static function properName(string $name)
    {
        return title_case(static::cleanName($name));
    }

    /**
     * Get raw list of tables.
     * 
     * @return array
     */
    private static function tables () {
        return array_map('reset', \DB::select('SHOW TABLES'));
    }

    /**
     * Get raw list of columns.
     * 
     * @return array
     */
    private static function columns (string $table) {
        return array_map(function ($column) {
            return (object) array_change_key_case((array)$column, CASE_LOWER);
        }, \DB::select('SHOW COLUMNS FROM ' . $table));
    }

    /**
     * Get clean list of columns.
     * 
     * @return array
     */
    private static function cleanColumns (string $table) {
        return array_map(function ($column) {
            return array_filter([
                'name' => [
                    'original' => $column->field,
                    'plural' => static::properPluralName($column->field),
                    'singular' => static::properSingularName($column->field)
                ],
                'required' => $column->null !== 'NO',
                'type' => $type = static::type($column->type, $column->field),
                'relation' => $type === 'relation' ? static::relation($column) : null,
                'default' => $column->default
            ]);
        }, static::visibleColumns($table));
    }

    private static function relation (object $column) {
        $table = str_plural(static::cleanName($column->field));
        $model = static::model($table);
        $instance = static::modelInstance($table);
        $display = 'name';
        $return = 'id';
        
        if (method_exists($model, 'getRelationDisplay')) {
            $display = $instance->getRelationDisplay();
        }

        if (method_exists($model, 'getRelationReturn')) {
            $return = $instance->getRelationReturn();
        }

        return [
            'table' => $table,
            'display' => $display,
            'return' => $return
        ];
    }

     /**
     * Filter columns based on model fillables.
     * 
     * @return array
     */
    private static function visibleColumns (string $table) {
        $model = static::modelInstance($table);
        $hidden = $model->getHidden();
        
        return array_values(array_filter(static::columns($table), function ($column) use ($hidden) {
            return !in_array($column->field, $hidden);
        }));
    }

    /**
     * This function returns a HTML/JS compatible type for a given column.
     *
     * @param string
     * @param string
     * @return string
     */
    private static function type(string $type, string $field = null)
    {
        if (ends_with($field, '_id')) {
            return 'relation';
        }

        if (str_contains($type, '(')) {
            $parts = explode('(', $type);
            $type = $parts[0];
            $length = (int) rtrim($parts[1], ')');
        }
        
        switch ($type) {
            case 'text':
                return 'textarea';
            case 'date':
            case 'datetime':
            case 'time':
            case 'timestamp':
                return 'date';
            case 'tinyint':
                return 'boolean';
            case 'smallint':
            case 'mediumint':
            case 'bigint':
            case 'int':
            case 'year':
                return 'integer';
            case 'json':
                return 'array';
            case 'decimal':
            case 'double':
            case 'float':
                return 'float';
            default:
                return 'string';
        }
    }

    /**
     * Get class from name.
     * 
     * @return Class
     */
    private static function class (string $name, $default = null) {
        return class_exists($name) ? $name : $default;
    }

    /**
     * Get model from table.
     * 
     * @return BaseModel|Model
     */
    private static function model (string $table) {
        return static::class('App\\'.static::properSingularName($table), 'Kaya\Admin\Models\BaseModel');
    }

    /**
     * Get model instance from table.
     * 
     * @return BaseModel|Model
     */
    private static function modelInstance (string $table) {
        $model = static::model($table);
        if ($model instanceof BaseModel) {
            return $model::forTable($table);
        } else {
            return new $model;
        }
    }
}
