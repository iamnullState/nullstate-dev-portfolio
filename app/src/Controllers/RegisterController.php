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

        if (!hash_equals($tokenSess, $tokenPost)) {
            Flash::set('error', 'Invalid CSRF token. Please try again.');
            header('Location: /register');
            exit;
        }

        if(empty($_POST['termsconfirm']))
        {
            Flash::set('error', 'You must agree to the terms and conditions.');
            header('Location: /register');
            exit;
        }

        if(empty($_POST['dataconfirm']))
        {
            Flash::set('error', 'You must agree to the data policy.');
            header('Location: /register');
            exit;
        }

        if(empty($_POST['ageconfirm']))
        {
            Flash::set('error', 'You must agree to be over the age of 16.');
            header('Location: /register');
            exit;
        }
        

        Flash::set('success', 'Security check passed (CSRF).');
        header('Location: /register');
        exit;
       }
    }

    public function isempty($value, $flash): bool
    {
        return empty(trim($value)) ? (Flash::set('error', $flash) && true) : false;
    }
}