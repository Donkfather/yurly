<?php declare(strict_types=1);

namespace Yurly\Inject\Request;

use Yurly\Core\Context;

class Delete extends RequestFoundation implements RequestInterface
{

    protected $props = [];

    /**
     * DELETE values are simply stored as object properties - unsanitized!
     */
    public function __construct(Context $context)
    {

        parent::__construct($context);

        $this->type = 'Delete';

    }

    /**
     * Hydrate the request class
     */
    public function hydrate(): void
    {

        parse_str(file_get_contents("php://input"), $this->props);

    }

    /**
     * Return all properties as an array
     */
    public function toArray(): array
    {

        return $this->props;

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
