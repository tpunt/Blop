<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta description="{{ pageDescription }}" />
        <meta keywords="{{ pageKeywords }}" />

        <title>{{ pageTitle }}</title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/{{ superRoute }}.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            {% if post is empty %} <!-- needed? depends on error handling of no results from PHP -->
            <p>The post ID is invalid.</p>
            {% else %}
            <h1>{{post.getPostTitle }}</h1>

            <p>
                Post on {{ post.getPostDate }}<br />
                By Lindsey Downing
            </p>

            <section>
                {{ post.getPostBody }}
            </section>
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>