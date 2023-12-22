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

**user** — имя пользователя

**password** — пароль пользователя

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


# Класс XInfoSelect в InfoCMS
Класс используется для формирования запроса SELECT, который выводит из базы данных определенные значения.

Функции класса:

**1) sql(tablename, array(field:comparison,field1:comparison,…), boolen)** — формирует запрос SELECT.

Пример:
```
 $Select = XinfoSelect::connect();
 return $Select->sql('news',array('id:count','title'))->run();
```
в итоге получится запрос **SELECT COUNT(id),title FROM `news`**

где,

**news** — таблица базы данных.

**COUNT(id)** — это id:count.

comparison имеет три значения

**:count** — COUNT()

**:max** — MAX()

**:min** — MIN()

**:sum** — SUM()

**boolen** значение — это присутствие оператора DISTINCT, который выбирает только уникальные значения, может иметь значения **true** (присутствует) и **false** (отсутствует оператор)

**SELECT DISTINCT title FROM `news`**

Используется только с одним полем **field**.

**2) run(sql)** — запускает выполнение запроса.

Пример:
```
$Select = XinfoSelect::connect();
return $Select->run("SELECT COUNT(id),title FROM `news`");
```
где параметр **sql** это обычный mysql запрос

**3) query()** — формирует запрос в виде строки(используется для проверки правильности запроса).
Пример:
```
 $Select = XinfoSelect::connect();
 echo $Select->sql('news',array('id:count','title'))->query();
```
скрипт выведет на экран запрос **(SELECT COUNT(id),title FROM `news`)**

**4) union()** — используется для объединения двух запросов.
Пример:
```
 $Select = XinfoSelect::connect();
 return $Select->sql('news',array("title"))->union()->sql('news1',array("title"))->run();
```
код инициализирует запрос **SELECT title FROM `news` UNION SELECT title FROM `news1`** объединяя параметром **UNION**;
**
5) groupBy(array(field,field1,…) , array(having:comparison => value, having1:comparison:comparation_1 => value1,…))** — используется для объединения полей по значению.

Пример:
```
 $Select = XinfoSelect::connect();
 return $Select->sql('news',array("title"))->groupBy(array("id","title"),array("id:>" => 3,"id:<=:and" => 10))->run();
```
В итоге сформируется запрос:

**( SELECT title FROM `news` GROUP BY id,title HAVING id > 3 AND id <= 10 )**

где,

в первом массиве **field** — это имя столбца таблицы **news**, в нашем случае это два столбца **id** и **title**.

Второй массив содержит:

**HAVING** - применяется для фильтрации столбцов.

где,

**having** — столбец id который содержит значение ключа массива **comparison (:> и :<=)** равное > и ≤ соответственно,

а также **comparation_1** которое содержит значение **:and** разделитель между условиями равный **AND** (в первом элементе массива оно игнорируется).

**value** — значение для сравнения в нашем случае это **3** и **10**

Значения **comparison**:

**:>** — больше,

**:<** — меньше,

**:<=** — меньше или равно,

**:>=** больше или равно,

**:=** — равно,

**:<>** — не равно

Значения **comparation_1**:

**:or** — логическое или

**:and** — логическое и.

**6) all(tablename,boolen)** — функция выводит все записи или подсчитывает количество записей таблицы.

Пример:
```
$Select = XInfoSelect::connect();
return $Select->all('news',false)->run();
```
news — это название таблицы

**boolen** принимает два значения

**true**
```
$Select = XInfoSelect::connect();
return $Select->all('news',true)->run();
```
**( SELECT COUNT(*) FROM `news` )**

**false**
```
$Select = XInfoSelect::connect();
return $Select->all('news',false)->run();
```
**( SELECT * FROM `news` )**

**7) limit($start,$end)** — выводит определенный лимит записей в зависимости от значения.

Пример:
```
$Select = XInfoSelect::connect();
return $Select->sql('news',array("title"))->limit(2,4)->run();
```
**( SELECT title FROM `news` LIMIT 2,4 )**

Пример выводит записи начиная с 2 по 4.

**8) offset($value)** — отсчитывает записи из таблицы начиная с указанного значения.

Пример:
```
$Select = XInfoSelect::connect();
return $Select->sql('news',array("title"))->offset(5)->run();
```
**( SELECT title FROM `news` OFFSET 5 )**

Вводит записи начиная с 5-ой.

**9) join(tablename:join, array(field:comparison => value,…field_n:comparison:comparison_1 => value_n))** — используется для объединения таблиц.

Пример:
```
$Select = XInfoSelect::connect();
return $Select->sql('news')->join("user:left",array("user.id:>" => "20","user.title:AND" => "news.title"))->run();
```
В итоге сформируется запрос:

**( SELECT * FROM `news` LEFT JOIN `user` ON (user.id >20 AND user.title = news.title) )**

где,

**tablename** — имя таблицы для объединения join

**join** — тип **join** который имеет несколько значений **LEFT,RIGHT,INNER и FULL** соответствующий значениям **join** mysql запроса. Если **comparison** не указан по умолчанию будет равен join.

**field** — это имя столбца таблицы, в нашем примере это user.id и user.title

Значения **comparison**:

**:>** — больше,

**:<** — меньше,

**:<=** — меньше или равно,

**:>=** больше или равно,

**:=** — равно,

**:<>** — не равно

Значения **comparation_1**:

**:or** — логическое или

**:and** — логическое и.

**value…value_n** — это значение поля таблицы в нашем случае 20 и news.title

**10) orderBy(field:description)** — водит таблицу исходя из значений field(название поля) и description(сортировка в исходном или обратном порядке).

Пример:
```
$Select = XInfoSelect::connect();
return $Select->sql('news')->orderBy(['id:ASC'])->run();
```
В итоге сформируется запрос:

**( SELECT * FROM `news` ORDER BY `id` ASC )**

**field** — имя поля для сортировки, в нашем случае **id**

**description** сортировка имеет значения:

**ASC** - сортирует по возрастанию

**DESC** - сортирует по убыванию

**11) where(array(field:comparation => value,…field_n:comparation:comparation_1 => value_n))** — фильтрует значение таблиц в зависимости от условий, используется **pdo**. Используется только один раз в главном запросе.

Пример:
```
$Select = XInfoSelect::connect();
return $Select->sql('news')->sql('news')->Where(array("news.id:>" => 3,"news.id:<:and" => 30))->run();
```
**( SELECT * FROM `news` WHERE news.id > :newsid1 AND news.id < :newsid2 )**

где,

**field** — это имя столбца таблицы, в нашем примере это user.id

Значения **comparison**:

**:>** — больше,

**:<** — меньше,

**:<=** — меньше или равно,

**:>=** больше или равно,

**:=** — равно,

**:<>** — не равно

Значения **comparation_1**:

**:or** — логическое или

**:and** — логическое и.

**value…value_n** — это значение поля таблицы в нашем случае 3 и 30

**12) underWhere(array(field:comparation => value,…field_n:comparation:comparation_1 => value_n))** — фильтрует значение таблиц в зависимости от условий, обращаясь к значениям напрямую без **pdo**.

Пример:
```
 $Select = XInfoSelect::connect();
return $Select->sql('news')->sql('news')->join("user",array("user.id" => "20","user.title:AND" => "news.title"))->underWhere(array("news.id:>" => 3,"news.id:<:and" => 30)) ->run();
```
**( SELECT * FROM `news` JOIN `user` ON (user.id=20 AND user.title=news.title) WHERE news.id > 3 AND news.id < 30 )**

где,

**field** — это имя столбца таблицы, в нашем примере это news.id

Значения comparison:

**:>** — больше,

**:<** — меньше,

**:<=** — меньше или равно,

**:>=** больше или равно,

**:=** — равно,

**:<>** — не равно

Значения **comparation_1**:

**:or** — логическое или

**:and** — логическое и.

**value…value_n** — это значение поля таблицы в нашем случае 3 и 30

**P.S.** если с помощью вспомогательных функций не возможно сформировать нужный запрос, вы можете использовать функцию **run()** в которой можно сформировать любой sql - запрос.




# Класс XInfoUpdate в InfoCMS
Класс формирует запрос **UPDATE** для обновления строк таблиц базы данных MySQL

**1) sql(tablename, array(field,field_1,…field_n))** — формирует запрос UPDATE.

Пример:
```
$arraySql = array('title'=>"infoCMS","titleToo" => 2);
$Update = new XinfoUpdate();
return $Update::connect()->sql('news',$arraySql)->run();
```
в итоге получится запрос **UPDATE news SET title = infoCMS, titleToo= 2**

где,

**news** — таблица базы данных.

**field,field_1,…field_n** — обновляемый массив значений, в нашем случае это **array('title'=>"infoCMS","titleToo" => 2)**

**2) run(sql)** — запускает выполнение запроса.

Пример:
```
$Update = XinfoUpdate::connect();
return $Update->run("UPDATE news SET title = title WHERE id = 1");
```
где параметр **sql** это обычный mysql запрос

**3) query()** — формирует запрос в виде строки(используется для проверки правильности запроса).

Пример:
```
$arraySql = array('title'=>"infoCMS");
$arrayWhere = array('id' => 1);
echo XinfoUpdate::connect();->sql('news',$arraySql)->where($arrayWhere)->query();
```
скрипт выведет на экран запрос **UPDATE news SET title = infoCMS WHERE id = 1**

**4) join(tablename:join, array(field:comparison => value,…field_n:comparison:comparison_1 => value_n))** — используется для объединения таблиц.

Пример:
```
$arraySql = array('newsToo.title' => "infoCMS");
$Update = XinfoUpdate::connect();
return $Update->join("newsToo",array('news.newsToo' => "newsToo.id"))->sql('news',$arraySql)
->run();
```
В этом запросе таблица **news** проверяет равенство поля **newsToo** полю **id** таблицы **newsToo (ON (news.newsToo=newsToo.id))** если поле соответствует значению, поле **title** таблицы **newsToo** становится равным infoCMS.

![](https://sun9-15.userapi.com/impf/c848632/v848632178/177cba/Y6C62EP3lAM.jpg?size=293x151&quality=96&sign=6b37a52d38ed62549afc2beea966dc51&type=album)

![](https://sun9-29.userapi.com/impf/c848632/v848632178/177cc1/Bv3LbifvNo8.jpg?size=241x146&quality=96&sign=eaf95151e87665775807c4d7125077df&type=album)

Запрос:

**UPDATE news JOIN `newsToo` ON (news.newsToo=newsToo.id) SET newsToo.title = infoCMS**

где,

**tablename** — имя таблицы для объединения join

**join** — тип **join** который имеет несколько значений **LEFT,RIGHT,INNER и FULL** соответствующий значениям **join** mysql запроса. Если **comparison** не указан по умолчанию будет равен join.

**field** — это имя столбца таблицы, в нашем примере это **news.newsToo**

Значения **comparison**:

**:>** — больше,

**:<** — меньше,

**:<=** — меньше или равно,

**:>=** больше или равно,

**:=** — равно,

**:<>** — не равно

Значения **comparation_1**:

**:or** — логическое или

**:and** — логическое и.

**value…value_n** — это значение поля таблицы в нашем случае **newsToo.id**

**5) limit($value)** — обновляет определенный лимит записей в зависимости от значения.

Пример:
```
$arraySql = array('title' => "infoCMS");
$Update = XinfoUpdate::connect();
return $Update->sql('news',$arraySql)->limit(2)->run();
```
**UPDATE news SET title = infoCMS LIMIT 2**

Пример обновляет 2-а первых поля.

![](https://sun9-12.userapi.com/impf/c848632/v848632178/177cdb/24ZN6ft6u0I.jpg?size=307x135&quality=96&sign=9b8f9500a20873f77c26e450423b7f19&type=album)

**6) orderBy(field:description)** — обновляет таблицу исходя из значений field(название поля) и description(сортировка в исходном или обратном порядке).

Пример:
```
$arraySql = array('title' => "infoCMS");
$Update = XinfoUpdate::connect();
return $Update->sql('news',$arraySql)->orderBy(['id:DESC'])->limit(2)->run();
```
В нашем случае обновляются две записи значения **title** таблицы **news** отсортированные по убыванию.

![](https://sun9-76.userapi.com/impf/c848632/v848632467/17dc74/0jz_rWc9Ofo.jpg?size=309x138&quality=96&sign=428cd43d03a1911aef06902233a57edb&type=album)

Запрос:

**UPDATE news SET title = :title1 ORDER BY `id` DESC LIMIT 2**

**field** — имя поля для сортировки, в нашем случае **id**

**description** сортировка имеет значения:

**ASC** - сортирует по возрастанию

**DESC** - сортирует по убыванию

**7) where(array(field:comparation => value,…field_n:comparation:comparation_1 => value_n))** — фильтрует значение таблиц в зависимости от условий, используется **pdo**. Используется только один раз в главном запросе.

Пример:
```
$arraySql = array('title' => "infoCMS");
$arrayWhere = array('news.id:<=' => 3,'news.id:>:or' => 10);
$Update = XinfoUpdate::connect();
return $Update->sql('news',$arraySql)->where($arrayWhere)->run();
```

**UPDATE news SET title = infoCMS WHERE news.id <= 3 OR news.id > 10**

где,

**field** — имя столбца таблицы, в нашем примере это user.id

Значения **comparison**:

**:>** — больше,

**:<** — меньше,

**:<=** — меньше или равно,

**:>=** больше или равно,

**:=** — равно,

**:<>** — не равно

Значения **comparation_1**(в первом элементе массива оно игнорируется):

**:OR** — логическое или

**:AND** — логическое и.

**value…value_n** — это значение поля таблицы в нашем случае 3 и 10

Если с помощью методов не возможно сформировать нужный запрос используйте функцию **run()**.
