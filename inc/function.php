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
            <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-single.html">Автор</a></li>
        </ul>
    </div>
    <div class="entry-content">';
    if ($single == true) {
        $wraped_article .= '<p>' . $article['content'] . '</p>';
    } else {

        $wraped_article .= '<div class="read-more">
            <a href="index.php?id=' . $article['id']
            . '">Читать</a>
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


// Admin
/**
 * @return void
 */
function dashboard(): void
{
    $action = '';
    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
    }
    switch ($action) {
        case 'article-list':
            include './template/backend/pages/article-list.php';
            break;
        case 'article-add':
            $content = makeArticleForm('article-create', [], 'post');
            $title = 'Create';
            echo pageWrapper($title, $content);
            break;
        case 'article-create':
            if (articleCreate()) {
                goUrl('admin.php?action=article-list');
            } else {
                $title = 'Error!!!';
                $content = 'Что-то пошло не по плану';
                echo pageWrapper($title, $content);
            }
            break;
        case 'article-edit':
            $id =(int) $_GET['id'];
            $article = getArticleById($id);
            $content = makeArticleForm('article-update',$article,'post');
            $title = 'Edit';
            echo pageWrapper($title,$content);
            break;
        case 'article-update':
            if (articleUpdate ()) {
                goUrl('admin.php?action=article-list');
            }else{
                $title = 'Error!!!';
                $content = 'Что-то пошло не по плану';
                echo pageWrapper($title,$content);
            };
            break;
        case 'article-delete':
            $id =(int) $_GET['id'];
            articleDelete ($id);
            goUrl('admin.php?action=article-list');
            break;
        default:
            include './template/backend/partials/welcome.php';

    }
}

/**
 * @param string $action
 * @param array $article
 * @param string $method
 * @return string
 */
function makeArticleForm(string $action, array $article =[], string $method = 'get'):string
{
    $id = '';
    $title = '';
    $image = '';
    $content = '';
    if (!empty($article)){
        $id = $article['id'];
        $title = $article['title'];
        $image = $article['image'];
        $content = $article['content'];
    }
    $form ='<h5 class="card-title">Статья</h5>
            <form action="admin.php" method="' . $method .'">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="inputText" class="col-sm-2 col-form-label"> Заголовок </label>
                        <input class="form-control" type="text" name="title" value="' . $title .'">
                    </div>
                    <div class="col-12">
                        <label for="inputText" class="col-sm-2 col-form-label">Изображение</label>
                        <input class="form-control" type="text" name="image" value="' . $image .'">
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="id" value="' . $id .'">
                        <input type="hidden" name="action" value="' . $action .'">
                        <label for="inputText" class="col-sm-2 col-form-label">Содержание статьи</label>
                        <textarea class="tinymce-editor " name="content">
                        ' . $content .'
                        </textarea><!-- End TinyMCE Editor -->
                    </div>
                </div>                        
                <div class="text-center p-3">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                    <a href="admin.php?action=article-list"  class="btn btn-secondary">Закрыть</a>
                </div>
            </form>';
    return $form;
}

/**
 * @param string $page_title
 * @return string
 */
function pageTitleWrapper(string $page_title):string
{
    return '<div class="pagetitle">
        <h1>Form Editors</h1>
        <nav>
            <ol class="breadcrumb">// TODO : breadcrumb in function
                <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                <li class="breadcrumb-item">Статьи</li>
                <li class="breadcrumb-item active">'.$page_title.'</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->';
}

/**
 * @param string $title
 * @param string $content
 * @return string
 */
function pageWrapper(string $title, string $content):string
{
    $page =  '<main id="main" class="main">';
    //$page .= pageTitleWrapper($title);
    $page .= '<section class="section"><div class="row"><div class="col-lg-12">';
    $page .= $content ;
    $page .= '</div></div></section></main>';
    return $page;
}

/**
 * @return bool
 */
function articleCreate() : bool{
    $articleFields = checkFields( $_POST, articleFields ());
    $articles = getArticles();
    $lastId = end($articles)['id'];
    $id = $lastId + 1;
    $articles[$id] = [
        'id' => $id,
        'title' => $articleFields['title'],
        'image' => $articleFields['image'],
        'content' => $articleFields['content']
    ];
    saveArticles($articles);
    return true;
}


function articleUpdate()
{
    $articleItem = checkFields( $_POST, articleFields ());
    $articles = getArticles();
    if(isset($articles[$articleItem['id']])) {
        $articles[$articleItem['id']] = [
            'id' => $articleItem['id'],
            'title' => $articleItem['title'],
            'image' => $articleItem['image'],
            'content' => $articleItem['content']
        ];
        saveArticles($articles);
        return true;
    }else{
        return false;
    }


}
function articleDelete(int $id) : bool{
    $articles = getArticles();
    if(isset($articles[$id])){
        unset($articles[$id]);
        saveArticles($articles);
        return true;
    }
    return false;
}

/**
 * @param array $articles
 * @return bool
 */
function saveArticles(array $articles) : bool{
    file_put_contents('db/articles.json', json_encode($articles));
    return true;
}

/**
 * @return string[]
 */
function articleFields():array
{
  return [
      'id' ,
      'title' ,
      'image' ,
      'content'
  ];
}

/**
 * @param array $target
 * @param array $fields
 * @param bool $html
 * @return array
 */
function checkFields(array $target, array $fields, bool $html=true):array
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

/**
 * @return string
 */
function listOfWrappedArticles():string
{
    $articles = getArticles();
    $list = '';
    foreach ($articles as $article) {

        $list .= listArticleWrapper($article);
    }
    return $list;
}

/**
 * @param array $article
 * @return string
 */
function listArticleWrapper(array $article): string
{
    $wrapped_list = '
        <tr>
            <th scope="row">' . $article['id'] . '</th>
            <td>' . $article['title'] . '</td>
            <td>
                <img src="' . $article['image'] . '" alt="" class="img-fluid">
            </td>
            <td>
                <div class="btn-group" role="group" >
                <a class="btn btn-success" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                    href="admin.php?action=article-edit&id='
                    . $article['id'] .
                    '"><i class="bi bi-pencil"></i></a>
                <a class="btn btn-danger" 
                    data-bs-toggle="modal" data-bs-target="#modal-'. $article['id'] .'"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                    href="admin.php?action=article-delete&id='
                    . $article['id'] .
                    '"><i class="bi bi-trash3"></i></a>
                    <div class="modal fade" id="modal-'. $article['id'] .'" tabindex="-1" data-bs-backdrop="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Удаление</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Вы уверены что хотите удалить статью с ID '. $article['id'] .'
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                      <a  href="admin.php?action=article-delete&id=' . $article['id'] . '" class="btn btn-primary">Удалить</a>
                    </div>
                  </div>
                </div>
              </div><!-- End Disabled Backdrop Modal-->
              </div>
            </td>
        </tr>';

    return $wrapped_list;
}
