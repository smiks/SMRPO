[include]app/views/header.view.php[/include]

WELCOME<br>
{% if($isAdministrator) { %}
<a href='?page=adminpanel'>Admin Panel</a>
{% } %}
&nbsp;
<a href='?page=logout'>Logout</a>
&nbsp;
[include]app/views/footer.view.php[/include]