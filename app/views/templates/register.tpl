<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />

        <title><!-- {{ pageTitle }} --></title>

        <link rel="stylesheet" type="text/css" href="{{ baseURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ baseURI }}/public/css/register.css" />
    </head>
    <body>
        {% include 'global/header.tpl' %}

        <section id="mainframe">
            <p>Enter your login credentials here:</p>
            <br />
            <form action="{{ baseURI }}/register/validateRegistration" method="POST">
                <label for="fname">Forename:</label> <input type="text" id="fname" name="forename" />
                <br />
                <label for="sname">Surname:</label> <input type="text" id="sname" name="surname" />
                <br />
                <label for="email">Email:</label> <input type="text" id="email" name="email" />
                <br />
                <label for="pws">Password:</label> <input type="password" id="pws" name="pws" />
                <br />
                <label for="rpws">Repeat Password:</label> <input type="password" id="rpws" name="rpws" />
                <br />
                <input type="submit" name="submit" value="Sign Up" />
            </form>
            {% if regError %}
                <p class="error">{{ regError }}</p>
            {% endif %}
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>