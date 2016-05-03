<?php
namespace JayaCode\Framework\Core\View;

class View
{
    public function create($loc = "")
    {
        ob_start();

        require_once(__APP_DIR__ . "/resource/view/" . $loc);

        $content = ob_get_contents();

        ob_end_clean();
        return $content;
    }
}
