<?php

namespace App\Enums;

enum Casts  :string
{
    case STRING  = 'string';
    case ARRAY   = 'array';
    case BOOLEAN = 'boolean';
    case BOOL    = 'bool';
    case FLOAT   = 'float';
    case DOUBLE  = 'double';
    case DECIMAL = 'decimal';
    case INT     = 'int';
    case INTEGER = 'integer';
    case OBJECT  = 'object';
}
