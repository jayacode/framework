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

            case Query::TYPE_INSERT:
                return $this->insert();

            case Query::TYPE_UPDATE:
                return $this->update();

            case Query::TYPE_DELETE:
                return $this->delete();

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

        $table = $this->query->table;
        $this->queryString .= " FROM {$this->getFormattedTableOrColumn($table)}";

        $this->queryString .= $this->where();
        
        $this->queryString .= $this->sort();
        $this->queryString .= $this->limit();

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
                $columns[$key] = $this->getFormattedTableOrColumn($val);
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
                $q = $q->append(" {$type} ");
            }

            if (is_string($arr)) {
                $q = $q->append($arr);
            }

            if (is_array($arr)) {
                $q = $q->append($this->buildArrWhere($arr));

                $this->params[] = $arr[2];
            }
        }

        return $q->count()?$q->prepend(" WHERE ")->__toString():"";
    }

    /**
     * @return string
     */
    private function sort()
    {
        if (empty($this->query->sort)) {
            return "";
        }

        $sort = $this->query->sort;

        if (!isset($sort['column']) || !isset($sort['order'])) {
            return "";
        }

        return " ORDER BY {$this->getFormattedTableOrColumn($sort['column'])} {$sort['order']}";
    }

    /**
     * @return string
     */
    private function limit()
    {
        if (!is_numeric($this->query->limit)) {
            return "";
        }

        $str = " LIMIT {$this->query->limit}";

        if (is_numeric($this->query->offset)) {
            $str .= " OFFSET {$this->query->offset}";
        }
        return $str;
    }

    /**
     * @param $arr
     * @return string
     */
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

    /**
     * @return string
     */
    private function insert()
    {

        $this->params = $this->query->values;

        $table = $this->query->table;
        $this->queryString = "INSERT INTO {$this->getFormattedTableOrColumn($table)}";

        $this->queryString .= "({$this->selectColumn()})";

        $this->queryString .= " VALUES(";

        $params = array();

        for ($i=0, $c=count($this->query->columns); $i<$c; $i++) {
            $params[$i] = "?";
        }

        $this->queryString .= join(', ', $params).")";

        return $this->queryString;
    }

    /**
     * @return string
     */
    private function update()
    {
        $this->params = $this->query->values;

        $table = $this->query->table;
        $this->queryString = "UPDATE {$this->getFormattedTableOrColumn($table)} SET ";

        $arrSet = array();
        foreach ($this->query->columns as $column) {
            $arrSet[] = "{$this->getFormattedTableOrColumn($column)} = ?";
        }
        $this->queryString .= join(", ", $arrSet);

        $this->queryString .= $this->where();

        return $this->queryString;
    }

    /**
     * @return string
     */
    private function delete()
    {
        $table = $this->query->table;
        $this->queryString = "DELETE FROM {$this->getFormattedTableOrColumn($table)}";
        $this->queryString .= $this->where();

        return $this->queryString;
    }

    /**
     * @param null $str
     * @return null|string
     */
    private function getFormattedTableOrColumn($str = null)
    {
        $tmpStr = $str?$str:$this->query->table;
        $strArr = explode(".", $tmpStr);

        foreach ($strArr as $key => $val) {
            $strArr[$key] = "`{$val}`";
        }

        return join(".", $strArr);
    }
}
