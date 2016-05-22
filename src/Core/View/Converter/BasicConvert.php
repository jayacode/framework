<?php
namespace JayaCode\Framework\Core\View\Converter;

class BasicConvert implements Converter
{
    protected $content;

    protected $options = [
        "preg_replace" => [
            [
                '/{{/',
                '/}}/',
                '/\[\[/',
                '/\]\]/',
                '/^\s*@(.*)$/m',
                '/^\s*\[@\s*parent\s*([\w|\.]*)\s*@\]\s*$/m',
                '/\s*\[@\s*content\s*(\w*)\s*@\](.*)\[@\s*endcontent\s*@\]/Usm'
            ],
            [
                '<?php echo(htmlspecialchars(',

                ")); ?>",

                '<?php ',

                " ?>",

                "<?php \\1 ?>",

                "<?php \$this->setParent('\\1'); ?>",

                " <?php if (array_key_exists('\\1', \$this->contentParent)) {
                    print(\$this->contentParent['\\1']);
                } elseif (!\$this->parent) { ?>
                    \\2
                <?php } else { ?>
                    <?php ob_start(); ?> \\2 <?php \$this->contentParent['\\1'] = ob_get_contents(); ob_end_clean(); ?>
                <?php } ?>"
            ]
        ],
    ];

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function build($content = null, $options = array())
    {
        $this->options = $options + $this->options;

        if (!is_null($this->content)) {
            $content = $this->content;
        }

        return preg_replace($this->options['preg_replace'][0], $this->options['preg_replace'][1], $content);
    }
}
