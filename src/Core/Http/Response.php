<?php
namespace JayaCode\Framework\Core\Http;

use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response extends BaseResponse
{
    /**
     * if content is an array, then convert to json
     * @param mixed $content
     * @return BaseResponse
     */
    public function setContent($content)
    {
        if (is_array($content)) {
            $this->headers->set('Content-Type', 'application/json');
            $content = json_encode($content);
        }

        return parent::setContent($content);
    }
}
