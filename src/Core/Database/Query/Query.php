<?php
namespace JayaCode\Framework\Core\Database\Query;

use JayaCode\Framework\Core\Database\Query\Grammar\Grammar;

/**
 * Class Query
 * @property array where
 * @property array columns
 * @property mixed query
 * @property null params
 * @package JayaCode\Framework\Core\Database\Query
 */
class Query
{
    /**
     *
     */
    const TYPE_QUERY = 'QUERY';
    /**
     *
     */
    const TYPE_SELECT = 'SELECT';

    /**
     * @var string
     */
    public $table;

    /**
     * @var array
     */
    protected $attributes = array(
        'where' => array(),
        'columns' => array()
    );

    /**
     * @var string
     */
    protected $type = "SELECT";

    /**
     * @param null $table
     */
    public function __construct($table = null)
    {
        $this->table = $table;
    }

    /**
     * @param $queryStr
     * @param $params
     * @return Query
     */
    public static function sql($queryStr, $params = null)
    {
        $query = new self();
        if ($params) {
            $query->params = $params;
        }
        $query->setType(self::TYPE_QUERY);
        $query->query = $queryStr;
        return $query;
    }

    /**
     * @param $table
     * @return Query
     */
    public static function table($table)
    {
        return new self($table);
    }

    /**
     * @param $columns
     * @return $this
     */
    public function select($columns = null)
    {
        $this->attributes['columns'] = $columns;
        $this->type = "SELECT";
        return $this;
    }

    /**
     * @param $query
     * @param string $type
     * @return Query
     */
    public function whereQ(Query $query, $type = "AND")
    {
        if ($query->getType() == Query::TYPE_QUERY) {
            $this->attributes['where'][] = array($type, $query->query);
        }
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @param string $type
     * @return Query
     */
    public function where($column, $value, $operator = "=", $type = "AND")
    {
        $this->attributes['where'][] = array($type, array($column, $operator, $value));
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @return Query
     */
    public function andWhere($column, $value, $operator = "=")
    {
        return $this->where($column, $value, $operator, "AND");
    }

    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @return Query
     */
    public function orWhere($column, $value, $operator = "=")
    {
        return $this->where($column, $value, $operator, "OR");
    }

    /**
     * @param Grammar $grammar
     * @return array
     */
    public function build(Grammar $grammar)
    {
        $grammar->setQuery($this);

        $queryStr = $grammar->build();
        $queryParams = isset($this->attributes['params'])?$this->attributes['params']:$grammar->getParams();

        return [$queryStr, $queryParams];
    }

    /**
     * @param $name
     * @return array
     */
    public function __get($name)
    {
        return arr_get($this->attributes, $name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}