<?php
// Включаем строгую типизацию
declare(strict_types=1);
/**
 * @param $some
 * отладочная функция
 */
function dd($some){
    echo '<pre>';
    print_r($some);
    echo '</pre>';
}
/**
 * @param $url
 * редирект на указаный URL
 */
function goUrl(string $url){
    echo '<script type="text/javascript">location="';
    echo $url;
    echo '";</script>';
}
/**
 * функция возвращает масив статей
 * @return array
 */
function getArticles() : array
{
    return json_decode(file_get_contents('db/articles.json'), true);
}
/**
 * функция возвращает статью  в виде масива по id
 * @param int $id
 * @return array
 */
function getArticleById(int $id):array
{
    $articleList =getArticles();
    $curentArticle = [];
    if (array_key_exists($id, $articleList)) {
        $curentLrticle = $articleList[$id];
    }
    return $curentArticle;
}
/**
 * функция генерирует список <li> из Json
 * и формирует ссылки вида URI index.php?id=1
 *
 * @return string
 */
function getArticleList(): string
{
    $articles = getArticles();
    $link = '';
    foreach ($articles as $article) {
        $link .= '<li class="nav-item"><a class="nav-link" href="index.php?id='. $article['id']
            . '">'. $article['title']. '</a></li>';
    }
    return $link;
}