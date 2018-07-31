<?php

namespace Kaya\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Jedrzej\Pimpable\PimpableTrait;

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
