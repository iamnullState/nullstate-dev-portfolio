<?php
declare(strict_types=1);

namespace Nullstate\Controllers;

use Nullstate\Core\View;
use Nullstate\Models\User;
use Nullstate\Core\Flash;

final class LoginController
{
    public function index(): void
    {

        View::render('auth/index.html.twig', [
            'date' => date("Y.m.d ⇾ l"),
            'title' => 'authenticate',
            'app_url' => getenv('APP_URL') ?: 'http://localhost',
            'og_title' => 'Welcome to meh dev portfolio',
            'meta_description' => 'nullStat3 portfolio blog thingy. I make stuff, sometimes I write about it. I just want to be 1337 like Zero Cool.',
            'og_description' => 'nullStat3 portfolio blog thingy. I make stuff, sometimes I write about it. I just want to be 1337 like Zero Cool.',
            'meta_keywords' => 'portfolio, projects, skills, developer, designer',
            'meta_author' => 'nullStat3',
            'og_image' => '/assets/images/og-index.png',
            'appName' => getenv('APP_NAME') ?: 'nullStat3',
        ]);
    }


    public function store(): void
    {
        $emailRaw = trim($_POST['email'] ?? '');
        $email    = $emailRaw !== '' ? mb_strtolower($emailRaw, 'UTF-8') : '';

        if ($email === '') {
            Flash::set('error', 'Email cannot be empty.');
            header('Location: /login');
            exit;
        }

        $exists = User::query()->where('email', $email)->exists();

        if ($exists) {
            Flash::set('success', 'Email exists in database.');
            header('Location: /login');
            exit;
        } else {
            Flash::set('error', 'No account found with that email.');
            header('Location: /login');
            exit;
        }
    }
}