<?php
namespace JayaCode\Framework\Tests\Core\Query;

use JayaCode\Framework\Core\Database\Query\Grammar\GrammarMySql;
use JayaCode\Framework\Core\Database\Query\Query;

class MySqlQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testSelectProvider()
     * @param $expected
     * @param Query $query
     */
    public function testSelect($expected, Query $query)
    {
        $this->assertEquals($expected, $query->build(new GrammarMySql()));
    }

    /**
     * @return array
     */
    public function testSelectProvider()
    {
        /**
         * array (
         *  $expected,
         *  $query
         * )
         */
        return array(
            array(
                array(
                    "SELECT * FROM `foo`",
                    array()
                ),
                Query::table("foo")->select()
            ),

            array(
                array(
                    "SELECT `col` FROM `foo`",
                    array()
                ),
                Query::table("foo")->select("col")
            ),

            array(
                array(
                    "SELECT `col1`, `col2` FROM `foo`",
                    array()
                ),
                Query::table("foo")->select(["col1", "col2"])
            ),

            array(
                array(
                    "SELECT `col`, VERSION() FROM `foo`",
                    array()
                ),
                Query::table("foo")->select(["col", Query::sql("VERSION()")])
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` = ?",
                    array("colVal")
                ),
                Query::table("foo")->select()->where("col", "colVal")
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` LIKE ?",
                    array("%colVal%")
                ),
                Query::table("foo")->select()->where("col", "%colVal%", "LIKE")
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` = ? AND `col2` = ?",
                    array("colVal", "col2Val")
                ),
                Query::table("foo")->select()->where("col", "colVal")->andWhere("col2", "col2Val")
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` = ? OR `col2` = ?",
                    array("colVal", "col2Val")
                ),
                Query::table("foo")->select()->where("col", "colVal")->orWhere("col2", "col2Val")
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` = ? AND (1=1)",
                    array("colVal")
                ),
                Query::table("foo")->select()->where("col", "colVal")->whereQ(Query::sql("(1=1)"))
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` LIKE ?",
                    array("colVal")
                ),
                Query::table("foo")->select()->like("col", "colVal")
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` = ? AND `col2` LIKE ?",
                    array("colVal", "%colVal2%")
                ),
                Query::table("foo")->select()->where("col", "colVal")->like("col2", "%colVal2%")
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` = ? AND `col2` LIKE ?",
                    array("colVal", "%colVal2%")
                ),
                Query::table("foo")->select()->where("col", "colVal")->andLike("col2", "%colVal2%")
            ),

            array(
                array(
                    "SELECT * FROM `foo` WHERE `col` = ? OR `col2` LIKE ?",
                    array("colVal", "%colVal2%")
                ),
                Query::table("foo")->select()->where("col", "colVal")->orLike("col2", "%colVal2%")
            ),

            array(
                array(
                    "INSERT INTO `foo`(`col1`, `col2`) VALUES(?, ?)",
                    array("colVal", "colVal2")
                ),
                Query::table("foo")->insert(array("col1" => "colVal", "col2" => "colVal2"))
            ),

            array(
                array(
                    "UPDATE `foo` SET `col1` = ?, `col2` = ? WHERE `id` = ?",
                    array("colVal", "colVal2", "idVal")
                ),
                Query::table("foo")->update(array("col1" => "colVal", "col2" => "colVal2"))->where("id", "idVal")
            ),

            array(
                array(
                    "DELETE FROM `foo` WHERE `id` = ?",
                    array("idVal")
                ),
                Query::table("foo")->delete()->where("id", "idVal")
            )
        );
    }
}
