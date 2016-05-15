<?php
namespace JayaCode\Framework\Core\Database\Query\Grammar;

use JayaCode\Framework\Core\Database\Query\Query;
use Stringy\Stringy;

/**
 * Class GrammarMySql
 * @package JayaCode\Framework\Core\Database\Query\Grammar
 */
class GrammarMySql extends Grammar
{

    /**
     * @return string
     */
    public function build()
    {
        switch ($this->query->getType()) {
            case Query::TYPE_SELECT:
                return $this->select();

            case Query::TYPE_QUERY:
                return $this->query->query;
        }
        return null;
    }

    /**
     * @return string
     */
    private function select()
    {
        $this->queryString = "SELECT ";

        $this->queryString .= $this->selectColumn();

        $this->queryString .= " FROM `{$this->query->table}`";

        $this->queryString .= $this->where();

        return $this->queryString;
    }

    /**
     * @return string
     */
    private function selectColumn()
    {
        $columns = $this->query->columns;
        if (is_null($columns)) {
            $columns = [Query::sql("*")];
        }

        if (is_string($columns)) {
            $columns = array($columns);
        }

        foreach ($columns as $key => $val) {
            if ($columns[$key] instanceof Query) {
                $columns[$key] = $columns[$key]->query;
            } else {
                $columns[$key] = "`{$val}`";
            }
        }

        return implode(', ', $columns);
    }

    /**
     * @return string
     */
    private function where()
    {
        if (count($this->query->where) <= 0) {
            return "";
        }

        $q = Stringy::create("");

        foreach ($this->query->where as $where) {
            $type = $where[0];
            $arr = $where[1];

            if ($q->count() > 1) {
                $q = $q->append(" {$this->getSeparatorWhereGrammar($type)} ");
            }

            if (is_string($arr)) {
                $q = $q->append($arr);
            }

            if (is_array($arr)) {
                $q = $q->append($this->buildArrWhere($arr));

                arr_push($this->params, $arr[2]);
            }
        }

        return $q->count()?$q->prepend(" WHERE ")->__toString():"";
    }

    private function buildArrWhere($arr)
    {
        if (count($arr) != 3) {
            throw new \OutOfBoundsException();
        }

        switch ($arr[1]) {
            case "BETWEEN":
                return "`{$arr[0]}` {$arr[1]} ? AND ?";
            default:
                return "`{$arr[0]}` {$arr[1]} ?";
        }
    }
}
