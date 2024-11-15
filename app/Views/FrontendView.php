<?php

namespace App\Views;

use App\Models\ArticleModel;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class FrontendView
{
    private $twig;
    private $model;

    public function __construct()
    {
        $loader = new FilesystemLoader('./template');
        $this->twig = new Environment($loader);
        $this->model = new ArticleModel();
    }

    public function showSingleArticle(array $article) 
    {
        $articles = $this->model->getArticles();
        $sidebar = array_reverse($articles);
        return $this->twig->render("./content/frontend/blog-list.twig", ['articles' => $article, 'sidebar' => $sidebar, 'codeword' => 'frontend']);
    }

    public function showAllArticles(array $articles) 
    {
        $sidebar = array_reverse($articles);
        return $this->twig->render("./content/frontend/blog-list.twig", ['articles' => $articles, 'sidebar' => $sidebar, 'codeword' => 'frontend']);
    }
}
