<?php
//All
// Включаем строгую типизацию
declare(strict_types=1);

/**
 * @param $some
 * отладочная функция
 */
function dd($some)
{
    echo '<pre>';
    print_r($some);
    echo '</pre>';
}

/**
 * @param $url
 * редирект на указаный URL
 */
function goUrl(string $url)
{
    echo '<script type="text/javascript">location="';
    echo $url;
    echo '";</script>';
}

/**
 * функция возвращает масив статей
 * @return array
 */
function getArticles(): array
{
    return json_decode(file_get_contents('db/articles.json'), true);
}

/**
 * функция возвращает статью  в виде масива по id
 * @param int $id
 * @return array
 */
function getArticleById(int $id): array
{
    $articleList = getArticles();
    $curentArticle = [];
    if (array_key_exists($id, $articleList)) {
        $curentArticle = $articleList[$id];
    }
    return $curentArticle;
}

//Main
/**
 * @return string
 */
function main(): string
{
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $article = getArticleById($id);
    } else {
        $article = '';
    }

    if (empty($article)) {
        $content = blogEntrysList();
    } else {
        $content = blogEntryWrapper($article, true);
    }
    return $content;
}

/**
 * @return string
 */
function blogEntrysList(): string
{
    $articles = getArticles();
    $blog_entrys_list = '';
    foreach ($articles as $article) {
        $blog_entrys_list .= blogEntryWrapper($article);
    }
    return $blog_entrys_list;
}

/**
 * @param array $article
 * @param $single
 * @return string
 */
function blogEntryWrapper(array $article, $single = false): string
{
    $wraped_article = '<article class="entry">
    <div class="entry-img">
        <img src="' . $article['image'] . '" alt="" class="img-fluid">
    </div>
    <h2 class="entry-title">
        <a href="index.php?id=' . $article['id']
        . '">' . $article['title'] . '</a>
    </h2>
    <div class="entry-meta">
        <ul>
            <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-single.html">Admin</a></li>
        </ul>
    </div>
    <div class="entry-content">';
    if ($single == true) {
        $wraped_article .= '<p>' . $article['content'] . '</p>';
    } else {

        $wraped_article .= '<div class="read-more">
            <a href="index.php?id=' . $article['id']
            . '">Read More</a>
        </div>';
    }
    $wraped_article .= '</div></article>';
    return $wraped_article;
}

/**
 * Вывод последних 5ти новостей
 * @return string
 */
function sidebar(): string
{
    $articles = getArticles();
    $articles = array_reverse($articles);
    $content = '';
    for($i=0;$i<=4;$i++)
    {
        $content .= '<div class="post-item clearfix">
            <picture>
                <img src="' . $articles[$i]['image'] . '"  class="img-fluid img-thumbnail" alt="...">
            </picture>
            <h4><a href="index.php?id=' . $articles[$i]['id'] . '">' . $articles[$i]['title'] . '</a></h4>
        </div>';
    }
    return $content;
}

//Calculator
function calc() :string
{
    $content ='';
    if (empty($_GET))
    {
        return $content = '<p>Ничего не передано!</p>';
    }

    if (empty($_GET['operation']))
    {
        return $content = '<p>Не передана операция</p>';
    }

    if (empty($_GET['x1']) || empty($_GET['x2']))
    {
        return $content = '<p>Не переданы аргументы</p>';
    }
    $x1 = $_GET['x1'];
    $x2 = $_GET['x2'];

    switch ($_GET['operation']) {
        case '+':
            $result = $x1 + $x2;
            break;
        case '-':
            $result = $x1 - $x2;
            break;
        case '/':
            $result = $x1 / $x2;
            break;
        case '*':
            $result = $x1 * $x2;
            break;
        default:
            return $content = '<p>Операция не поддерживается</p>';
    }
    $content = '<p>Результат вычеслений: ' . $result . '</p>';
    return $content;
}
