<?php
declare(strict_types=1);

namespace Nullstate\Controllers;

use Nullstate\Core\View;
use Nullstate\Models\User;

final class HomeController
{
    public function index(): void
    {
        $users = User::orderBy('id', 'desc')->limit(10)->get();

        View::render('home/index.html.twig', [
            'title' => 'Welcome',
            'users' => $users,
        ]);
    }
}