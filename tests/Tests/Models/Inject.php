<?php

namespace Tests\Models;

class Inject
{

    public function __construct(\Yurly\Core\Context $context)
    {

        echo "TestsModelsInject";

    }

}
