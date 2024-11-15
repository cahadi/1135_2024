<?php


namespace App\Models;


class ArticleModel
{
    public function getArticles(): array
    {
        return json_decode(file_get_contents('./db/articles.json'), true);
    }

    public function getArticleById(int $id): array
    {
        $articleList = $this->getArticles();
        $curentArticle = [];
        if (array_key_exists($id, $articleList)) {
            $curentArticle = $articleList[$id];
        }
        return $curentArticle;
    }

    public function checkFields(array $target, array $fields, bool $html=true):array
    {
        $checkedFields = array();
        foreach ($fields as $name){
            if(isset($target[$name]) && $html == false) {
                $checkedFields[$name] = trim($target[$name]);
            }elseif (isset($target[$name]) && $html == true) {
                $checkedFields[$name] = htmlspecialchars(string: trim($target[$name]));
            }
        }
        return $checkedFields;

    }
    public function articleFields():array
    {
      return [
          'id' ,
          'title' ,
          'image' ,
          'content'
      ];
    }

    public function save(array $articles)
    {
        file_put_contents('./db/articles.json', json_encode($articles));
    }

}