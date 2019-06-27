<?php declare(strict_types=1);

namespace Yurly\Core;

/*
 * Create a Url by auto-detecting values
 */

class UrlFactory
{

    /*
     * Autodetect URL settings and return a Url object
     */
    public static function autodetect()
    {

        // Basic lookup
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $port = $_SERVER['SERVER_PORT'];

        // Determine the script filename so we can exclude it from the parsed path
        $scriptFilename = basename($_SERVER['SCRIPT_FILENAME']);
        // Determine the correct request Uri
        $requestUri =
            (isset($_SERVER['YURLY_REQUEST_URI']) ? $_SERVER['YURLY_REQUEST_URI'] :
            (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI']
        ));
        if (strpos($requestUri, '?') !== false) {
            $requestUri = strstr($requestUri, '?', true);
        }

        $rootBasePath = (isset($_SERVER['SCRIPT_NAME']) ? rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') : '/');
        $rootUri = ($rootBasePath == '' ? '' : (isset($_SERVER['SCRIPT_NAME']) ? rtrim($_SERVER['SCRIPT_NAME'], '/') : '/'));

        $pathParsed = parse_url($scheme . '://' . $host . $requestUri . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
        $pathComponents = explode('/', substr($pathParsed['path'], 1));
        $queryString = (isset($pathParsed['query']) ? $pathParsed['query'] : '');

        // Send back complete Url object
        return new Url([
            'requestMethod' => $requestMethod,
            'requestUri' => $requestUri,
            'rootUri' => $rootUri,
            'rootBasePath' => $rootBasePath,
            'scheme' => $scheme,
            'host' => $host,
            'port' => $port,
            'pathComponents' => $pathComponents,
            'queryString' => $queryString
        ]);

    }

}
