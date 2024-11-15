<?php
namespace App\Controllers;

use App\Models\ArticleModel;
use App\Views\FrontendView;

class FrontendController
{
    private $model;
    private $view;


    public function __construct()
    {
        $this->model = new ArticleModel();
        $this->view = new FrontendView();
    }

    public function articles() {
        $articles = $this->model->getArticles();
        return $this->view->showAllArticles($articles);
    }

    public function singleArticle(int $id)
    {
        $article = $this->model->getArticleById($id);
        return $this->view->showSingleArticle([$article]);
    }
}
