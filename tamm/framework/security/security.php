<?php

namespace Tamm\Framework\Security;

use Tamm\Framework\Skeleton\Security\ISecurity;
use Tamm\Framework\Skeleton\Security\IUser;
use Tamm\Framework\Skeleton\Security\IRole;
use Tamm\Framework\Skeleton\Security\IPermission;
use Tamm\Framework\Skeleton\Security\IAuthentication;
use Tamm\Framework\Skeleton\Security\IAuthorization;

class Security implements ISecurity {
    public function generateToken(string $text){

    }

    public function getUserByField($field,$value) : ?IUser 
    {
        return null;
    }

    public function getRoleByField($field,$value) : ?IRole
    {
        return null;
    }

    public function getPermissionByField($field,$value) : ?IPermission
    {
        return null;
    }

    public function getAuthentication() : ?IAuthentication
    {
        return null;
    }

    public function getAuthorization() : ?IAuthorization
    {
        return null;
    }
}