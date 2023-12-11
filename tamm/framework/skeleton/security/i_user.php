<?php

namespace Tamm\Framework\Skeleton\Security;

interface IUser {
    public function getUserByUsername(string $username);
}