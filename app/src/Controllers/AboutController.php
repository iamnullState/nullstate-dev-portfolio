<?php
declare(strict_types=1);

namespace Nullstate\Controllers;

use Nullstate\Core\View;

final class AboutController
{
    public function index(): void
    {

        View::render('about/index.html.twig', [
            'date' => date("Y.m.d ⇾ l"),
            'title' => '/whois nullStat3',
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
}