# Структура InfoCMS

![](https://sun9-34.userapi.com/impf/c851132/v851132706/f390f/l2I1Ml8gnWU.jpg?size=553x305&quality=96&sign=196a664a42fb5cd413aae0cb50c1e375&type=album)

— **adminPanel** — в ней хранится администрационная панель infoCMS.

a) adminPanel/controllers — MVC контроллеры администрационной панели.

b) adminPanel/models — MVC модули администрационной панели.

c) adminPanel/views — MVC виды администрационной панели.

d) adminPanel/views/layouts — в этой папке хранятся, хедер шаблона администрационной панели (**header.php**) и футер (**footer.php**)

— **components** — ядро где хранится реализация структуры MVC

a) components/inClass — здесь находятся все пользовательские классы infoCMS

— **config** — здесь находится файл конфигурации базы данных **db_params.php** , конфигурация роутеров (ссылок для различных контроллеров) **routes.php**, так же находится php файл предназначенный для обработки ссылок с помощью регулярных выражений.

— **controllers** — MVC контроллеры сайта.

— **models** — MVC модули сайта.

— **template** — хранятся все подключаемые файлы


a) template/css — стили

b) template/images — картинки

c) template/js — javascript фалы

— **views** — MVC виды сайта.

a) views/layouts — в этой папке хранятся, хедер (**header.php**) и футер (**footer.php**) шаблона.



# Работа с routes в InfoCMS

1) Структура **routes.php**

![](https://sun9-4.userapi.com/impf/c851028/v851028927/f1aec/lOgQR2JXfEI.jpg?size=419x121&quality=96&sign=210421e472d281a2594d3c0c0b699645&type=album)

Роутер принимает массив из различных параметров для правильного формирования ссылок.

**Ключ массива** — это вид ссылки

**Значение массива** — это обращение к модели и контроллеру с соответствующими параметрами

Пример 1:
```
'info' => 'admins/index'
```
**info** — это адрес ссылки, в нашем случае это site.ru/**info**

**admins/index** — это обращение в модели и контролеру, с которой эта ссылка работает.

admins — это модель класса **admins** фала **Admins.php** моделей сайта.

index — это контроллер (функция) **actionIndex()** класса **AdminsController** файла **AdminsController.php** который находится в папке с контроллерами.

Пример 2:
```
'<ids:nums>/<id:nums>' => 'admin/view/<id>/<ids>'
```
Здесь формируется ссылка из параметров ids и id которые могут быть только числом, в этом случае к параметру добавляется значение **:nums** из файла **routes_values.php**

Адрес ссылки в таком случае будет **site.ru/число/число**, например **site.ru/1/2**

**admin** — это модель ссылки.

**view** — это значение контроллера(функция) **actionView()** класса **AdminController** файла **AdminController.php**, который находится в папке с контроллерами.

**id и ids **— это параметры, которые передаются в контроллер. Параметры в роутере разделяются косой чертой **id/ids** и соответствуют значениям параметров ссылок **ids** и **id**.

![](https://sun9-1.userapi.com/impf/c851028/v851028074/f0dfc/F9d7uRyf82A.jpg?size=282x20&quality=96&sign=4f9a959ba0b7869c39231099c85d86c9&type=album)

Если вы захотите привязать несколько ссылок к одному контроллеру нужно использовать конструкцию ключа массива (**admin|login**) где, **admin** и **login** две разные ссылки, обрабатываемые одним контроллером.

2) Структура **routes_values.php**

![](https://sun9-79.userapi.com/impf/c848624/v848624980/16aacd/PaO6Metvb44.jpg?size=350x197&quality=96&sign=619a9d2bb12b81a4b06f530620b681e1&type=album)

**Ключ массива** — это константа, которая передается в ссылки фала routes.php

Значение ключа обязательно должна экранироваться символами < и >.

**Значение массива **— это регулярное выражение которое используется для сортировки ссылок.

Пример 1:
```
'<id:nums>' => 'admin/view/<id>'
```
В этом случае значение поля id может быть только цифрой.


# Подключение базы данных MySql

Для подключения базы данных используется **config/db_params.php**

![](https://sun9-43.userapi.com/impf/c855528/v855528300/1845c/ltBgvhqBiBw.jpg?size=228x117&quality=96&sign=af0de57edc37e56b97cadac02ea13b69&type=album)

**host** — локальный хост сервера базы данных

**dbname** — имя базы данных

# Подключение template, header и footer в InfoCMS

1) template

Для подключения css js и images из templete используются константы **CSS JS** и **IMAGES**.

Пример 1 (при использовании Twig):
```
<script type="text/javascript" src="{{constant('JS')}}script.js"></script>
```
В этом примере используется Twig шаблонизатор, который подключает константу **JS**.

Пример 2 (используя класс View):
```
<script type="text/javascript" src=<?=JS?>script.js"></script>
```
Список констант:

**CSS** — /template/css/

**JS** — /template/js/

**IMAGES** — /template/images/

2) header и footer

![](https://sun9-17.userapi.com/impf/c851032/v851032935/f6974/oyqItlK3FA0.jpg?size=181x74&quality=96&sign=59f2f3ea298696d40a8951d5a4c1ed54&type=album)

**{% include 'layouts/header.php' %}** — подключение header-а с помощью шаблонизатора Twig

**{% include 'layouts/footer.php %}** — подключение footer-a c помощью шаблонизатора Twig

**<?php include(HEADER);?>** — подключение header-а с помощью View.

**<?php include(FOOTER);?>** — подключение footer-a c помощью View.

Для админ-панели используются константы **HEADERADMIN** и **FOOTERADMIN**.


# Взаимодействие MVC в InfoCMS
![](https://sun9-79.userapi.com/impf/c849024/v849024734/16729a/8bwrorRwh6Q.jpg?size=807x449&quality=96&sign=dde1ab8141cb1b40bc2819e4dea95a30&type=album)

1) Модуль **Admin.php**

```
<?php
namespace models;
use components\inClass\XInfoSelect;
    class Admin
    {
        public static function runId($id)
        {
            $ar = array('id' => $id);
            return XinfoSelect::connect()->sql('news', array("title"))
                ->where($ar)
                ->run();

        }
    }
```
Модуль **Admin** инициализирует функцию **runId** с параметром **$id**, которая будет использована в контроллере **AdminController**.

Создается класс для работы с базой данных.

Инициализировать класс можно двумя способами:

1)
```
  return XinfoSelect::connect()->sql('news', array("title"))
                ->where($ar)
                ->run();
```
2)
```
  $XinfoSelect = XinfoSelect::connect() 
  return $XinfoSelect->sql('news', array("title"))
                ->where($ar)
                ->run();
```
Вид запроса класса **$XinfoSelect** выглядит так:

**SELECT title FROM `news` WHERE id = $id**

return передает массив полученный классом **$XinfoSelect** в контроллер.

2) Контроллер **AdminController.php**
```
<?php
use models\Admin;
use components\Twig;
class AdminController
{
	public function actionView($id)
	{
		if($id)
		{
		$newsItem = Admin::runId($id);
		return Twig::connect(true)->render('news/view.php', array( 'key' => $newsItem));
		}
	}
}
```
В контроллере создается **actionView**, который получает параметр **$id** из роутера:
```
'<id:nums>' => 'admin/view/<id>'
```
Выполняется проверка существования **$id**, после вызывается функция модуля с параметром **$id**.
```
$newsItem = Admin::runId($id);
```
**return** получает вид **news/view.php** с помощью класса **Twig** шаблонизатора **twig** и выводит на экран.
```
return Twig::connect(true)->render('news/view.php', array('key' => $newsItem));
```
**news/view.php** — это путь к представлению

**array( 'key' => $newItem )** — массив передаваемый для обработки представлением.

Метод **connect** имеет булевые значения.

**true** — использовать представление из папки **adminPanel/views**.

**false** — использовать представление из папки **views**.

Метод по умолчанию имеет значение false.

3) Вид **news/view.php**

Для работы с представлением используется шаблонизатор **twig**.
```
{% include 'layouts/header.php' %}
<p>{{ key[0]["title"] }}</p>
{% include 'layouts/footer.php' %}
```
**{% include 'layouts/header.php' %}** — подключает шапку представления.

**{{ key[0]["title"] }}** — выводит значение **title** полученное из параметра контроллера $newsItem.

**{% include 'layouts/footer.php' %}** — подключает футер.

Также можно использовать класс **view** как шаблон вида в контроллере **AdminController.php**:
```
return View::run('news/view', array( 'key' => $newsItem));
```
Вид **news/view.php** будет выглядеть следующим образом:
```
<?php include(HEADER); ?>
  <?=$key['0']['title']?>
<?php include(FOOTER);?>
```
Где существуют две константы инициализирующее **header** и **footer** вида, а так же массив **$key**.

Есть третья переменная при использовании которой вид выглядит следующим образом:

```
return View::run('news/view', array(), false);
```
**true** — использовать представление из папки **adminPanel/views**.

**false** — использовать представление из папки **views**.

**user** — имя пользователя

**password** — пароль пользователя
