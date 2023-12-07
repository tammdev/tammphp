<?php

namespace Tamm\Framework\Skelton\Security;

interface IUser {
    public function getUserByUsername(string $username);
}