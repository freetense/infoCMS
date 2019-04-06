{% include 'layouts/header.php' %}
  <h1>Заголовок</h1>
        <p>{{ key[0]["title"] }}</p>
{{data|raw}}
{% include 'layouts/footer.php' %}
