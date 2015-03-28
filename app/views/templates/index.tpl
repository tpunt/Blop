<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta description="{{ pageDescription }}" />
        <meta keywords="{{ pageKeywords }}" />

        <title>{{ pageTitle }}</title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/index.css" />

        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="{{ siteURI }}/public/javascript/beaverslider.js"></script>
        <script src="{{ siteURI }}/public/javascript/beaverslider-effects.js"></script>
        <script src="{{ siteURI }}/public/javascript/beaverslider-config.js"></script>
    </head>
    <body>
        <aside id="socialSideBar">

        </aside>

        {% include 'global/header.tpl' %}

            <div class="wrapper-img"><div id="imageSlider"></div></div>
        <section id="mainframe">

            <section class="leftBox">
                {{ pageContent.current|raw }}
            </section>

            <!-- <aside id="blogRoll">
                content here
            </aside> -->

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