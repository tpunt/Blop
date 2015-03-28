<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta description="{{ pageDescription }}" />
        <meta keywords="{{ pageKeywords }}" />

        <title>{{ pageTitle }}{{product.getProductName }}</title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/products.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            {% if product is empty %} <!-- needed? depends on error handling of no results from PHP -->
            <p>The product ID is invalid.</p>
            {% else %}
            <p>
                pID: {{ product.getProductID }}<br />
                pName: {{product.getProductName }}<br />
                pDescription: {{ product.getProductDescription }}
                pStockLevel: {{ product.getProductStockLevel }}<br />
                pPrice: {{ product.getProductPrice }}<br />
                pPrevPhoto: {{ product.getProductPrevPhoto }}
            </p>
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>