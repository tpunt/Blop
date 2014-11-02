<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />

        <title><!-- {{ pageTitle }} --></title>

        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ siteURI }}/public/css/login.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            <p>Enter your login credentials here:</p>
            <br />
            <form action="{{ siteURI }}/login/validateLogin" method="POST">
                <label for="email">Email:</label> <input type="text" id="email" name="email" />
                <br />
                <label for="pws">Password:</label> <input type="password" id="pws" name="pws" />
                <br />
                <input type="submit" name="submit" value="Log In" />
            </form>
            {% if loginError %}
                <p class="error">{{ loginError }}</p>
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>