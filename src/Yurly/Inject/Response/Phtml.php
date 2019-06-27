<?php declare(strict_types=1);

namespace Yurly\Inject\Response;

use Yurly\Inject\Response\Exception\ResponseConfigException;

class Phtml extends ResponseFoundation implements ResponseInterface
{

    protected $contentType = 'text/html';
    protected $defaultExtension = '.phtml';

    public function render($params = null): void
    {

        // Make sure we can determine which template to render
        if (!$this->viewDir) {
            throw new ResponseConfigException("Phtml Response class cannot determine view file/path automatically. Please set using \$response->setView()");
        }

        if (!$this->viewFilename) {
            throw new ResponseConfigException("Phtml Response class cannot determine view filename. Please set using \$response->setViewFilename()");
        }

        $viewFile = $this->viewDir . '/' . $this->viewFilename . (strpos($this->viewFilename, '.') === false ? $this->defaultExtension : '');

        if (!file_exists($viewFile)) {
            throw new ResponseConfigException("Phtml Response class cannot find specified view file " . $viewFile);
        }

        $params = ($params != null ? $params : $this->viewParams);

        if (!headers_sent()) {
            http_response_code($this->statusCode);
            header('Content-Type: ' . $this->contentType);
        }

        $this->inc($viewFile, $params);

    }

    public function inc(string $file, $params = null): void
    {

        // Simply include it
        include($file);

    }

}
