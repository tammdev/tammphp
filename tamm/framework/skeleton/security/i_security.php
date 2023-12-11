<?php

namespace Tamm\Framework\Skeleton\Security;

interface ISecurity {
    public function generateToken(string $text);
    public function getUserByField($field,$value) : ?IUser;
    public function getRoleByField($field,$value) : ?IRole;
    public function getPermissionByField($field,$value) : ?IPermission;
    public function getAuthentication() : ?IAuthentication;
    public function getAuthorization() : ?IAuthorization;
}