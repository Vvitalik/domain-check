<?php

namespace App\Enums;

enum DomainCheckMethod: string
{
    case Get = 'GET';
    case Head = 'HEAD';
}
