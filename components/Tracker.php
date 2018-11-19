<?php

namespace Igniter\OnlineTracker\Components;

use System\Classes\BaseComponent;

class Tracker extends BaseComponent
{
    public function onRun()
    {
        app('tracker')->boot();
    }
}
