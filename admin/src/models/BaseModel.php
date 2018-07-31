<?php

namespace Kaya\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Jedrzej\Pimpable\PimpableTrait;
use Kaya\Admin\Controllers\DatabaseController;

class BaseModel extends Model
{
    use PimpableTrait;

    /**
     * Field to display for relation.
     * 
     * @var string
     */
    protected $relation_display;

    /**
     * Field to return for relation.
     * 
     * @var string
     */
    protected $relation_return;

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
     * Return the field name to display on relation query.
     * 
     * @return string
     */
    public function getRelationDisplay() {
        return $this->relation_display ?? 'name';
    }

    /**
     * Return the field name to return on relation query.
     * 
     * @return string
     */
    public function getRelationReturn() {
        return $this->relation_return ?? 'id';
    }

    /**
     * Return the related controller from table.
     * 
     * @param string $table
     * @return any
     */
    private static function model (string $table) {
        $model = 'App\\' . str_singular(title_case($table));
        return class_exists($model) ? $model : BaseModel::forTable($table);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call ($method, $parameters)
    {
        if (!method_exists($this, $method)) {
            if (in_array(str_singular($method) . '_id', $this->getFillable())) {
                if (str_singular($method) === $method) {
                    $table = str_plural($method);
                    return $this->belongsTo(static::model($table), $method . '_id', 'id');
                } else {
                    $field = str_singular($this->table);
                    return $this->hasMany(static::model($method), $field . '_id', 'id');
                }
            }
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Create a new model instance for a related model.
     *
     * @param  string  $class
     * @return mixed
     */
    protected function newRelatedInstance($class)
    {
        return tap(is_string($class) ? new $class : $class, function ($instance) {
            if (! $instance->getConnectionName()) {
                $instance->setConnection($this->connection);
            }
        });
    }
    
}
