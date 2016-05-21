<?php
namespace JayaCode\Framework\Core\View\Converter;

interface Converter
{
    public function setContent($str);
    public function build($content = null, $options = array());
}
