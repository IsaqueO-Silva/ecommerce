<?php

namespace Hcode;

class Model {

    private $values = []; /* Guarda os dados do objeto */

    public function __call($name, $args) {

        /* Checando se foi chamado get ou set */
        $method     = substr($name, 0, 3);

        /* Checando o nome do get/set */
        $fieldName  = substr($name, 3, strlen($name));

        switch($method) {

            case 'get':
                return $this->values[$fieldName];
            break;
            
            case 'set':
                $this->values[$fieldName] = $args[0];
            break;
        }
    }

    public function setData($data = array()) {

        foreach($data as $key => $value) {

            $this->{'set'.$key}($value);
        }
    }

    public function getValues() {

        return $this->values;
    }
}
?>