<?php

namespace Tamm\Framework\Skelton\Session;

interface ISession {
    public function get($key);
    public function set($key, $value);
    public function delete($key);
}