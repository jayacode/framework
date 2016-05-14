<?php
namespace JayaCode\Framework\Core\Database\Query\Grammar;

use JayaCode\Framework\Core\Database\Query\Query;

/**
 * Class Grammar
 * @package JayaCode\Framework\Core\Database\Query\Grammar
 */
abstract class Grammar
{
    /**
     * @var
     */
    protected $queryString;

    /**
     * @var Query
     */
    protected $query;

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @return mixed
     */
    abstract public function build();

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
