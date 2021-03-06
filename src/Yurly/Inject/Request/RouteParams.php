<?php declare(strict_types=1);

namespace Yurly\Inject\Request;

use Yurly\Core\Context;
use Yurly\Core\Utils\Canonical;

class RouteParams extends RequestFoundation implements RequestInterface
{

    protected $props = [];
    protected $lastError;

    /**
     * Route param values are simply stored as object properties - unsanitized!
     */
    public function __construct(Context $context)
    {

        parent::__construct($context);

        $this->type = 'RouteParams';

    }

    /**
     * Set the local route parameter variable
     */
    public function hydrate(): void
    {

        if (isset($this->context->getCaller()->annotations['canonical'])) {
            $this->props = Canonical::extract($this->context->getCaller(), $this->context->getUrl());
        }

        if (Canonical::getLastError()) {
            $this->lastError = Canonical::getLastError();
        }

    }

    /**
     * Return all properties as an array
     */
    public function toArray(): array
    {

        return $this->props;

    }

    /**
     * Return the last parsing error if available, or null
     */
    public function getLastError(): ?string
    {

        return $this->lastError;

    }

    /**
     * Magic getter method maps requests to the protected $props property
     */
    public function __get(string $property)
    {

        return (isset($this->props[$property]) ? $this->props[$property] : null);

    }

    /**
     * Magic isset method maps requests to the protected $props property
     */
    public function __isset(string $property): bool
    {

        return isset($this->props[$property]);

    }

}
