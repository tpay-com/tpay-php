<?php

namespace tpayLibs\src\Dictionaries;

class HttpCodesDictionary
{
    /**
     * List of http response codes the occurrence of which results in throw exception
     */
    const HTTP_CODES = [
        401 => '401: Unauthorized access',
        404 => '404: Resource not found on server',
        500 => '500: Internal Server Error',
        501 => '501: Not Implemented',
        502 => '502: Bad Gateway',
        503 => '503: Service Unavailable',
        504 => '504: Gateway Timeout',
        505 => '505: HTTP Version Not Supported',
    ];
}
