<?php

namespace Tamm\Modules\Account\Services;

use Tamm\Framework\Skelton\IAuthorization;
use Tamm\Framework\Skelton\IRole;
use Tamm\Framework\Skelton\IPermission;
// use Tamm\Framework\Skelton\ISession;

// Authorization service
class AuthorizationService implements IAuthorization
{
    public function hasPermission($requiredPermission)
    {
        // Retrieve the authenticated user from the session
        $user = $_SESSION['user'];

        // Retrieve the user's role and permissions from the database
        $role = $this->getRoleById($user->getRoleId());
        $permissions = $this->getPermissionsByRole($role);

        // Check if the user has the required permission
        return in_array($requiredPermission, $permissions);
    }

    public function getRoleById(int $id){

    }

    public function getPermissionsByRole(IRole $role){

    }
}