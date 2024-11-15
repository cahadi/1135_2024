<?php
namespace App\Controllers;

use App\Models\ArticleModel;
use App\Views\BackendView;

class BackendController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new ArticleModel();
        $this->view = new BackendView();
    }

    public function index()
    {
        return $this->view->welcome();
    }

    public function articles()
    {
        $articles = $this->model->getArticles();
        return $this->view->showAllArticles($articles);

    }

    public function editArticle(int $id = null)
    {
        if($id != null)
        {
            $article = $this->model->getArticleById($id);
            return $this->view->showArticleForm($article);
        }
        else
            return $this->view->showArticleForm();
    }

    public function createArticles()
    {   
        $articleFields = $this->model->checkFields( $_POST, $this->model->articleFields ());
        $articles = $this->model->getArticles();
        $lastId = end($articles)['id'];
        $id = $lastId + 1;
        $articles[$id] = [
            'id' => $id,
            'title' => $articleFields['title'],
            'image' => $articleFields['image'],
            'content' => $articleFields['content']
        ];
        $this->model->save($articles);
        $this->articles();
    }

    public function updateArticle()
    {
        $articleItem = $this->model->checkFields( $_POST, $this->model->articleFields ());
        $articles = $this->model->getArticles();
        if(isset($articles[$articleItem['id']])) {
            $articles[$articleItem['id']] = [
                'id' => $articleItem['id'],
                'title' => $articleItem['title'],
                'image' => $articleItem['image'],
                'content' => $articleItem['content']
            ];
            $this->model->save($articles);
            $this->articles();
        }else{
            return 'Error';
        }
    }

    public function deleteArticle(int $id)
    {
        $articles = $this->model->getArticles();
        if(isset($articles[$id])){
            unset($articles[$id]);
            $this->model->save($articles);
            $this->articles();
        }
        else
            return 'Error';
    }
}