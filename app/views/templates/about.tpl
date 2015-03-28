<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta description="{{ pageDescription }}" />
        <meta keywords="{{ pageKeywords }}" />

        <title>{{ pageTitle }}</title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/index.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            <h1>About Me</h1>
            <section class="leftBox">
                {{ pageContent.current|raw }}
            </section>

            {% if pageContent.next is null and pageContent.valid %}
            <section class="rightBox marginTop">
                {{ pageContent.current|raw }}
            </section>
            {% endif %}

            <div class="clearFloat"></div>

            {% if pageContent.next is null and pageContent.valid %}
            <section class="centerBox marginTop">
                {{ pageContent.current|raw }}
            </section>
            {% endif %}

            <div class="clearFloat"></div>
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>