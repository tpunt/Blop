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

            <h1>Products Overview</h1><!-- pagination here instead? -->

            {% if products is empty %}
            <p>No products to show!</p>
            {% else %}
                {% for product in products %}
            <section class="product">
                {% if product.getProductPrevPhoto %}
                <img src="{{ product.getProductPrevPhoto }}" title="..." />
                {% else %}
                <img src="{{ siteURI }}/public/images/noImageAvailable_thumbnail.gif" title="Image unavailable" />
                {% endif %}
                <p>
                    pID: {{ product.getProductID }}<br />
                    pName: <a href="{{ siteURI }}/product/{{ product.getProductID }}">{{product.getProductName }}</a><br />
                    pStockLevel: {{ product.getProductStockLevel }}<br />
                    pPrice: {{ product.getProductPrice }}<br />
                </p>
            </section>
                {% endfor %}
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>