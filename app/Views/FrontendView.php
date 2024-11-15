<?php

namespace App\Views;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class FrontendView
{
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('./template');
        $this->twig = new Environment($loader);
    }

    public function showSingleArticle(array $article) 
    {
        if(isset($article))
            return $this->twig->render("blog-list.twig", ['articles' => $article]);
        else
            return '<p>Ничего не найдено</p>';
    }

    public function showAllArticles(array $articles) 
    {
        echo $this->twig->render("blog-list.twig", ['articles' => $articles]);
    }
}
