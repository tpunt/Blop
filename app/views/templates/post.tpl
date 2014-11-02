<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />

        <title>{{ pageTitle }}</title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/products.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            {% if post is empty %} <!-- needed? depends on error handling of no results from PHP -->
            <p>The post ID is invalid.</p>
            {% else %}
            <section class="product">
                <p>
                    pID: {{ post.getPostID }}<br />
                    pTitle: <a href="{{ siteURI }}/post/{{ post.getPostID }}">{{post.getPostTitle }}</a><br />
                    pContent: {{ post.getPostBody }}<br />
                    pDate: {{ post.getPostDate }}<br />
                    pCreatorID: {{ post.getPostCreatorID }}
                </p><br />
            </section>
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>