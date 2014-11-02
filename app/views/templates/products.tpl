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

            <p>Products listing overview... (add this descr to database)</p><!-- pagination here instead? -->

            {% if products is empty %} <!-- needed? depends on error handling of no results from PHP -->
            <p>No products to show... (add to db?)</p>
            {% else %}
                {% for product in products %}
            <section class="product">
                <p>
                    pID: {{ product.getProductID }}<br />
                    pName: <a href="{{ siteURI }}/product/{{ product.getProductID }}">{{product.getProductName }}</a><br />
                    pStockLevel: {{ product.getProductStockLevel }}<br />
                    pPrice: {{ product.getProductPrice }}<br />
                    pPrevPhoto: {{ product.getProductPrevPhoto }}
                </p>
            </section>
                {% endfor %}
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>