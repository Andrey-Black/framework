<?php

namespace Core;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    protected $twig;

    public function __construct ()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../public/templates');
        $this->twig = new Environment($loader, [
            'cache' => __DIR__ . '/../public/cache',
            'debug' => true,
        ]);
    }

    public function render ($view, $data = [])
    {
        echo $this->twig->render($view . '.html', $data);
    }
}
