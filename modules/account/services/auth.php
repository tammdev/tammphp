<?php


// Authentication service
class AuthenticationService
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function login($username, $password)
    {
        // Retrieve user from the database based on the provided username
        $user = getUserByUsername($username);

        if ($user && $user->verifyPassword($password)) {
            // Successful login, create a session token
            $token = generateToken();

            // Create session in the database
            $this->session->createSession($user->getId(), $token);

            // Store user information in the session
            $_SESSION['user'] = $user;
            $_SESSION['token'] = $token;

            return true;
        }

        return false;
    }

    public function logout()
    {
        // Retrieve the user from the session
        $user = $_SESSION['user'];

        // Delete the session from the database
        $this->session->deleteSession($user->getId());

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
        $session = $this->session->getSession($token);

        // Validate if the session exists and matches the user's ID
        return $session && $session['user_id'] === $user->getId();
    }
}

// Authorization service
class AuthorizationService
{
    public function hasPermission($requiredPermission)
    {
        // Retrieve the authenticated user from the session
        $user = $_SESSION['user'];

        // Retrieve the user's role and permissions from the database
        $role = getRoleById($user->getRoleId());
        $permissions = getPermissionsByRole($role);

        // Check if the user has the required permission
        return in_array($requiredPermission, $permissions);
    }
}