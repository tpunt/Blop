<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />

        <title>{{ pageTitle }}</title>

        <link rel="stylesheet" type="text/css" href="{{ baseURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ baseURI }}/public/css/index.css" />

        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="{{ baseURI }}/public/javascript/beaverslider.js"></script>
        <script src="{{ baseURI }}/public/javascript/beaverslider-effects.js"></script>
        <script src="{{ baseURI }}/public/javascript/beaverslider-config.js"></script>
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">

        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>