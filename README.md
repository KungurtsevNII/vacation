<p align="center">
    <a href="http://a0252368.xsph.xsph.ru/" target="_blank"><h1 align="center">Работа системы</h1></a>
</p>
<h2>Описание системы</h2>
<p>В системе есть две роли: сотрудник и руководитель. </p>
<p>Рядовому сотруднику доступен следющий функционал: </p>
<ul>
    <li>Забронировать отпуск</li>
    <li>Посмотреть какие даты отпусков у других сотрудников</li>
    <li>Скорректировать интервалы своих отпусков</li>
</ul>
<p>Руководителю доступен следующий функционал:</p>
<ul>
    <li>Полномочия рядового сотрудника</li>
    <li>Поставить признак, что данные по отпуску конкретного сотрудника зафиксированы, т.е. согласовать отпуск СВОЕГО подчиненного</li>
</ul>
<p>После того, как руководитель согласовал отпуск подчиненного, сотрудник не может скорректировать данный отпуск.</p>
<p style="color:red">Cотрудник не может корректировать не свой отпуск, а руководитель может согласовывать отпуска только своих подчиненных.</p>
<h3>Данные для входа:</h3>
<p>У всех пользователей пароль - 123. Табельный номер можно взять из таблица `employees`. Дамп базы данных можно найти в корне проекта - `vacation.sql`.</p>
<h3>Технологии:</h3>
<ul>
    <li>Yii2</li>
    <li>MySQL</li>
</ul>
