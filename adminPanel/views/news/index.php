{% include 'layouts/header.php' %}
  <h1>Заголовок</h1>
 {% for datas in data|keys %}
        <p>{{ data[datas]["title"] }}</p>
    {% endfor %}
{% include 'layouts/footer.php' %}
