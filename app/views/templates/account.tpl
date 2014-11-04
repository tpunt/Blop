<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />

        <title><!-- {{ pageTitle }} --></title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/account.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            <aside id="accnav">
                <ul>
                    <li><a href="{{ siteURI }}">Account Overview</a></li>
                    <li><a href="{{ siteURI }}">Account Information</a></li>
                    <li><a href="{{ siteURI }}">...</a></li>
                </ul>
            </aside>

            <section id="dashboard">
                <p>User dashboard here.</p>
            </section>

            <div class="clearFloat"></div>
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>