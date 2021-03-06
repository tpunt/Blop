<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="noindex" />

        <title><!-- {{ pageTitle }} --></title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/{{ superRoute }}.css" />
        {% if subRoute %}
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/{{ superRoute }}/{{ subRoute }}.css" />
        {% endif %}
        <script src="{{ siteURI }}/public/javascript/{{ superRoute }}/global.js"></script>
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            <aside id="accnav">
                <ul>
                    <li><a href="{{ siteURI }}/{{ superRoute }}">Admin Overview</a></li>
                    <li><a href="{{ siteURI }}/{{ superRoute }}/pages">Update Site Content</a></li>
                    <li><a href="{{ siteURI }}/{{ superRoute }}/posts">Manage Blog</a></li>
                    <li><a href="{{ siteURI }}/{{ superRoute }}/products">Manage Products</a></li>
                </ul>
            </aside>

            <section id="dashboard">
                {% include superRoute ~ '/' ~ subRoute ~ '.tpl' %}
            </section>

            <div class="clearFloat"></div>
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>