<?php
declare(strict_types=1);

namespace Nullstate\Controllers;

use Nullstate\Core\View;
use Nullstate\Core\Flash;
use Nullstate\Models\User;
final class RegisterController
{
    public function index(): void
    {
        View::render('register/index.html.twig', [
            'date' => date("Y.m.d ⇾ l"),
            'title' => 'Register',
            'app_url' => getenv('APP_URL') ?: 'http://localhost',
            'og_title' => 'Welcome to meh dev portfolio',
            'meta_description' => 'nullStat3 portfolio blog thingy. I make stuff, sometimes I write about it. I just want to be 1337 like Zero Cool.',
            'og_description' => 'nullStat3 portfolio blog thingy. I make stuff, sometimes I write about it. I just want to be 1337 like Zero Cool.',
            'meta_keywords' => 'portfolio, projects, skills, developer, designer',
            'meta_author' => 'nullStat3',
            'og_image' => '/assets/images/og-index.png',
            'appName' => getenv('APP_NAME') ?: 'nullStat3',
            'errors' => [],
            'old'    => [],
        ]);
    }

    public function store(): void
    {
       if($_POST['submit'])
       {
        
        $tokenPost = $_POST['_token'] ?? '';
        $tokenSess = \Nullstate\Http\Middleware\Csrf::token() ?? '';
        $usernameRaw = trim($_POST['username'] ?? '');
        $username = mb_strtolower($usernameRaw, 'UTF-8');
        $emailLower = mb_strtolower(trim($_POST['email'] ?? ''), 'UTF-8');
        $password  = $_POST['password'] ?? '';
        $confirm   = $_POST['password_confirmation'] ?? '';

        if (!hash_equals($tokenSess, $tokenPost)) {
            Flash::set('error', '⊗ Invalid CSRF token. Please try again.');
            header('Location: /register');
            exit;
        }

        if (User::query()->where('email', $emailLower)->exists()) {
            Flash::set('error', '⊗ That email is already registered.');
            header('Location: /register'); exit;
        }

        if (!preg_match('/^[a-z0-9_]{3,32}$/', $username)) {
            Flash::set('error', '⊗ Username must be 3–32 characters, letters/numbers/underscore only.');
            header('Location: /register'); exit;
        }
        
        if (User::query()->where('username', $username)->exists()) {
            Flash::set('error', '⊗ That username is already taken.');
            header('Location: /register'); exit;
        }

        if (strlen($password) < 10) {
            Flash::set('error', '⊗ Password must be at least 10 characters.');
            header('Location: /register'); exit;
        }
        
        if (!hash_equals($password, $confirm)) {
            Flash::set('error', '⊗ Passwords do not match.');
            header('Location: /register'); exit;
        }

        $checks = [
            'termsconfirm' => '⊗ You must agree to the terms and conditions',
            'dataconfirm'  => '⊗ You must agree to the data policy',
            'ageconfirm'   => '⊗ You must agree to be over the age of 16',
            'email'        => '⊗ Email is required',
            'username'     => '⊗ Username is required',
            'password'     => '⊗ Password is required',
            'password_confirmation'    => '⊗ Password confirmation is required',
        ];
        
        $errors = [];

        foreach ($checks as $field => $message) {
            if (empty($_POST[$field])) {
                $errors[] = $message;
            }
        }

        if (!empty($errors)) {
            Flash::set('error', implode("\n", $errors));
            header('Location: /register');
            exit;
        }

        $hash = password_hash($password, PASSWORD_ARGON2ID);

        User::create([
            'email'         => $emailLower,
            'username'      => $username,
            'password_hash' => $hash,
            'role_id'       => 1, // Default role_id for new users
            'created_ip'    => inet_pton($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'),
        ]);

        Flash::set('success', 'Account created! You can now log in.');
        header('Location: /login');
        exit;
       }
    }

    public function isempty($value, $flash): bool
    {
        return empty(trim($value)) ? (Flash::set('error', $flash) && true) : false;
    }
}