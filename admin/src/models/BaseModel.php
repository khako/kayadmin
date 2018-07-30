<?php

namespace Kaya\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Create a new instance of BaseModel for the given table.
     * 
     * @param string $table
     * @return BaseModel
     */
    public static function forTable (string $table) {
        $model = (new static)->setTable($table);
        $model->fillable = array_column(\DB::select('SHOW COLUMNS FROM ' . $table), 'Field');
        return $model;
    }
    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
    }
}
