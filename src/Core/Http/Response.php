<?php
namespace JayaCode\Framework\Core\Http;

use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response extends BaseResponse
{
    /**
     * if content is an array, then convert to json
     * @param mixed $content
     */
    public function setDataContent($content)
    {
        if (is_array($content)) {
            $this->headers->set('Content-Type', 'application/json');
            $content = json_encode($content);
        }

        $this->setContent($content);
    }

    /**
     * @param mixed $content The response content, see setContent()
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     *
     * @return Response
     */
    public static function create($content = '', $status = 200, $headers = array())
    {
        return new static($content, $status, $headers);
    }

    /**
     * Setup response 404
     * @param string $path
     */
    public function setNotFound($path)
    {
        $this->setStatusCode(404);
        $this->setDataContent("not found : {$path}");
    }
}
