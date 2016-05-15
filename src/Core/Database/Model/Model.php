<?php
namespace JayaCode\Framework\Core\Database\Model;

use JayaCode\Framework\Core\Database\Database;

/**
 * Class Model
 * @package JayaCode\Framework\Core\Database\Model
 */
abstract class Model
{
    /**
     * @var Database
     */
    public static $db;

    /**
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * @var null
     */
    protected static $table = null;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var bool
     */
    protected $isNewRow = true;

    /**
     * @param array $data
     * @param bool $isNewRow
     */
    public function __construct($data = array(), $isNewRow = true)
    {
        $this->data = $data;
        $this->isNewRow = $isNewRow;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function create($data = array())
    {
        return new static($data);
    }

    /**
     * @param null $columns
     * @return Database
     */
    public static function select($columns = null)
    {
        static::$db->setModel(get_class(new static()), static::$table);
        return static::$db->select($columns);
    }

    /**
     * @param $name
     * @return array
     */
    public function __get($name)
    {
        return arr_get($this->data, $name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     *
     */
    public function delete()
    {
        //TODO: will be implemented after query builder delete finish
    }

    /**
     *
     */
    public function update()
    {
        //TODO: will be implemented after query builder update finish
    }

    /**
     *
     */
    public function save()
    {
        //TODO: will be implemented after query builder insert & update finish

        static::$db->setModel(get_class(new static()), static::$table);
        if ($this->isNewRow && static::$db->insert($this->data)) {
            $this->isNewRow = false;

            if ($lastInsertID = static::$db->lastInsertId()) {
                $newData = static::$db->table(static::$table)
                    ->select()
                    ->where($this->primaryKey, $lastInsertID)
                    ->first();

                $this->data = $newData?$newData:$this->data;
            }
        }

        return $this;
    }
}
