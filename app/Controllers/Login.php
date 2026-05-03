<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    /**
     * Show login page
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Handle login form submission
     */
    public function authenticate()
    {
        // Check if request is POST
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/login');
        }

        // Get form data
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $rememberMe = $this->request->getPost('rememberMe');

        // Validate input
        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email and password are required.');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Invalid email format.');
        }

        try {
            // Use UserModel to fetch user
            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Invalid email or password.');
            }

            // Verify password
            if (!password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Invalid email or password.');
            }

            // Check if user is active
            if ($user['status'] !== 'active') {
                return redirect()->back()->with('error', 'Your account has been disabled.');
            }

            // Set session data
            $sessionData = [
                'id'         => $user['id'],
                'email'      => $user['email'],
                'name'       => $user['name'],
                'role'       => $user['role'],
                'logged_in'  => true
            ];

            session()->set($sessionData);

            // Update last login timestamp
            $userModel->update($user['id'], [
                'last_login' => date('Y-m-d H:i:s')
            ]);

            // Handle remember me
            if ($rememberMe) {
                // Set cookie for remember me (30 days)
                setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
            }

            return redirect()->to('/admin/dashboard')->with('success', 'Welcome back!');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}
