<?php

namespace Tamm\Modules\Account\Services;

use Tamm\Application;
use Tamm\Framework\Skeleton\Security\IAuthentication;
use Tamm\Framework\Skeleton\Security\ISecurity;
use Tamm\Framework\Skeleton\Security\ISession;

// Authentication service
class AuthenticationService implements IAuthentication
{
    private $container;
    private $security;
    private $session;

    public function __construct()
    {
        $this->container    = Application::getContainer();
        $this->security     = $this->container->resolve(ISecurity::class);
        $this->session      = $this->container->resolve(ISession::class);
    }

    public function signin($username, $password)
    {
        // Retrieve user from the database based on the provided username
        $user = $this->security->getUserByUsername($username);

        if ($user && $this->security->verifyUserPassword($password)) {
            // Successful login, create a session token
            $token = $this->security->generateToken();

            // Create session in the database
            $this->session->set($user->getId(), $token);

            // Store user information in the session
            $_SESSION['user'] = $user;
            $_SESSION['token'] = $token;

            return true;
        }

        return false;
    }

    public function signout()
    {
        // Retrieve the user from the session
        $user = $_SESSION['user'];

        // Delete the session from the database
        $this->session->delete($user->getId());

        // Destroy the session variables
        session_unset();
        session_destroy();
    }

    public function isAuthenticated()
    {
        // Check if the user is authenticated (e.g., session validation)
        return isset($_SESSION['user']) && isset($_SESSION['token']) && $this->validateSession($_SESSION['user'], $_SESSION['token']);
    }

    private function validateSession($user, $token)
    {
        // Retrieve the session information from the database
        $session = $this->session->get($token);

        // Validate if the session exists and matches the user's ID
        return $session && $session['user_id'] === $user->getId();
    }

    private function getUserByUsername(string $username){

    }
}
