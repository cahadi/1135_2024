<div class="row justify-content-end p-4">
    <div class="col-lg-9 entries">
        <h5 class="card-title">Список всех статей</h5>
    </div>
    <div class="col-lg-3">
        <a href="admin.php?action=article-add" class="btn btn-success"><i class="bi bi-file-earmark-plus"></i>&nbsp;Добавить статью</a>
    </div>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Заголовок</th>
            <th scope="col">Изоброжение</th>
            <th scope="col">Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php
            echo listOfWrappedArticles();
        ?>
    </tbody>
</table>