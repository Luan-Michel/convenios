<?php

namespace Uepg\SGIAuthorizer\Exceptions;

class SGIAuthorizerException extends \Exception
{
    private $_options;

    public function __construct($options = array('params')) {

        $this->options = $options;
    }
}