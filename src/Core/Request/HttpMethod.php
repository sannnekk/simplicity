<?php

declare(strict_types=1);

namespace Simplicity\Core\Request;

enum HttpMethod
{
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;
    case OPTIONS;
    case HEAD;
    case TRACE;
    case CONNECT;
    case UNKNOWN;
}
