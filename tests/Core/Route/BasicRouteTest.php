<?php
namespace JayaCode\Framework\Tests\Core\Route;

use JayaCode\Framework\Core\Route\Collector\RouteCollector;
use JayaCode\Framework\Core\Route\Dispatcher\Dispatcher;
use JayaCode\Framework\Core\Route\Route;
use JayaCode\Framework\Core\Route\Status;

class BasicRouteTest extends \PHPUnit_Framework_TestCase
{

    public function testRoute()
    {
        $definitionRoute = function (RouteCollector $route) {
            $route->addRoute(Route::get("home", "/", "handleHome"));
            $route->addRoute(Route::get("user.id", "/user/{id:[1-9]*}", "handleUserId"));
            $route->addRoute(Route::get("article.title", "/article/{title}", "handleArticleTitle"));
            $route->addRoute(Route::post("article.save", "article/save", "handleArticleSave"));
            $route->addRoute(Route::delete("article.delete", "article/delete/{id}", "handleArticleDelete"));
        };

        /** @var Dispatcher $dispatcher */
        $dispatcher = \JayaCode\Framework\Core\Route\dispatcherBasic($definitionRoute);

        $result = $dispatcher->dispatch("GET", "/");
        $this->assertEquals([Status::FOUND, "handleHome"], $result);

        $result = $dispatcher->dispatch("GET", "/user/123");
        $this->assertEquals([Status::FOUND, "handleUserId", ["id" => 123]], $result);

        $result = $dispatcher->dispatch("GET", "/article/best-title");
        $this->assertEquals([Status::FOUND, "handleArticleTitle", ["title" => 'best-title']], $result);

        $result = $dispatcher->dispatch("POST", "/article/save");
        $this->assertEquals([Status::FOUND, "handleArticleSave"], $result);

        $result = $dispatcher->dispatch("DELETE", "/article/delete/123");
        $this->assertEquals([Status::FOUND, "handleArticleDelete", ["id" => 123]], $result);

        $result = $dispatcher->dispatch("GET", "/foo/bar");
        $this->assertEquals([Status::NOT_FOUND], $result);
    }
}
