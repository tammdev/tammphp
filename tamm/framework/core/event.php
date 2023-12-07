<?php

namespace Tamm\Framework\Core;

class Event
{
    protected $listeners = [];

    public function subscribe($event, $listener)
    {
        $this->listeners[$event][] = $listener;
    }

    public function trigger($event, $data = [])
    {
        if (isset($this->listeners[$event])) {
            foreach ($this->listeners[$event] as $listener) {
                $listener($data);
            }
        }
    }
}