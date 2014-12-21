<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />

        <title>{{ pageTitle }}{{post.getPostTitle }}</title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/posts.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">

            <p>Posts listing overview... (add this descr to database)</p><!-- pagination here instead? -->

            {% if posts is empty %} <!-- needed? depends on error handling of no results from PHP -->
            <p>No products to show... (add to db?)</p>
            {% else %}
                {% for post in posts %}
            <section class="postPreview">
                <p>
                    pID: {{ post.getPostID }}<br />
                    pTitle: <a href="{{ siteURI }}/post/{{ post.getPostID }}">{{post.getPostTitle }}</a><br />
                    pContent: {{ post.getPostBody }}<br />
                    pDate: {{ post.getPostDate }}<br />
                    pCreatorID: {{ post.getPostCreatorID }}
                </p><br />
            </section>
                {% endfor %}
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>