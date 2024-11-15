<?php
namespace App\Views;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class BackendView
{
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('./template');
        $this->twig = new Environment($loader);
    }

    public function welcome()
    {
        return $this->twig->render("./content/backend/welcome.twig", ['codeword' => 'backend']);
    }

    public function showAllArticles(array $articles)
    {        
        return $this->twig->render("./content/backend/article-list.twig", ['articles' => $articles, 'codeword' => 'backend']);
    }

    public function showArticleForm(array $article = null)
    {
        if($article != null){
            return $this->twig->render("./content/backend/article-form.twig", ['article' => $article, 'targer' => 'update']);
        }
        else{
            return $this->twig->render("./content/backend/article-form.twig", ['tagret' => 'save']);
        }
    }
}