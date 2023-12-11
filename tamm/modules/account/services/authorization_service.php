<?php

namespace Tamm\Modules\Account\Services;

use Tamm\Framework\Skeleton\IAuthorization;
use Tamm\Framework\Skeleton\IRole;
use Tamm\Framework\Skeleton\IPermission;
// use Tamm\Framework\Skeleton\ISession;

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