<?php

namespace Hcode;

use Rain\Tpl;

class Page {

    private $tpl;
    private $options = []; /* variáveis do template */
    private $defaults = [ /* variáveis padrão */
        'data'  => [] /* variáveis do template */
    ];

    public function __construct($opts = array(), $tpl_dir = '/views/') {

        $this->options = array_merge($this->defaults, $opts);

        $config = array(
            'tpl_dir'       => $_SERVER['DOCUMENT_ROOT'].$tpl_dir,
            'cache_dir'     => $_SERVER['DOCUMENT_ROOT'].'/views-cache/',
            'debug'         => false
        );

        Tpl::configure($config);

        $this->tpl = new Tpl();

        /* Setando as variáveis para o header */
        $this->setData($this->options['data']);

        $this->tpl->draw('header');
    }

    /* Define as variáveis do template */
    private function setData($data = array()) {

        foreach($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data = array(), $returnHTML = false) {

        /* Setando as variáveis para o template */
        $this->setData($data);

        $this->tpl->draw($name, $returnHTML);
    }

    public function __destruct() {

        $this->tpl->draw('footer');
    }
}
?>