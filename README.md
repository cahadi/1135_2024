# Подключение PHP к сайту
На первом уроке скачиваете папки с lesson-1 и разбираете, как оно работает (комментарии везде написаны)
Далее скачиваете какой-нибудь блог с bootstrap-а, либо продолжаете свой сайт:
  Сайт разделяете на части (Например: 1. head
                                      2. sidebar
                                      3. content
                                      4. footer )
  и подключаете их в index.php
P.S. Разметка теперь пишется с расширением .php
От 1го урока требуется ввывод статей из json файла, функция для этого уже присутствует в файлах.

На втором уроке делаете добавление статей на отдельной странице (делайте с расчетом на то, что дальше будет добавляться окно входа).
Вывод статей списком с кнопками редактирования и удаления (эти функции добавим чуть позже). Над списком создаем кнопку "Добавить статью" открывающую форму создания. Статья также сохраняется в json.

Далее делаем редактирование и удаление. Редактирование статей, по аналогии с добавлением (Данные передавать в туже форму).

Get и post
https://www.php.net/manual/en/reserved.variables.get.php
https://www.php.net/manual/en/reserved.variables.post.php

Сохранение
https://www.php.net/manual/en/function.file-put-contents.php
https://www.php.net/manual/en/function.json-encode.php
