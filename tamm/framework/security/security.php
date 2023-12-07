<?php

namespace Tamm\Framework\Security;

use Tamm\Framework\Skelton\Security\ISecurity;
use Tamm\Framework\Skelton\Security\IUser;
use Tamm\Framework\Skelton\Security\IRole;
use Tamm\Framework\Skelton\Security\IPermission;
use Tamm\Framework\Skelton\Security\IAuthentication;
use Tamm\Framework\Skelton\Security\IAuthorization;

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