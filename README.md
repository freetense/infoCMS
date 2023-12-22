### Структура InfoCMS

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
