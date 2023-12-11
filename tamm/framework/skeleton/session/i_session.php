<?php

namespace Tamm\Framework\Skeleton\Session;

interface ISession {
    public function get($key);
    public function set($key, $value);
    public function delete($key);
}