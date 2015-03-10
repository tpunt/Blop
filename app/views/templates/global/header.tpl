<header>
    <figure>
        <h1><a href="{{ siteURI }}">Lindsey's <sup>PT</sup></a></h1>
        <figcaption>The Home Training Specialist</figcaption>
    </figure>
    <section id="account">
        <a href="{{ siteURI }}/basket">Basket</a>

        {% if loggedIn %}
            <a href="{{ siteURI }}/account/logout">Log Out</a>
            <a href="{{ siteURI }}/account">Account</a>
            {% if pLevel == 1 %}
                <a id="admin" href="{{ siteURI }}/admin">Admin</a>
            {% endif %}
        {% else %}
            <a href="{{ siteURI }}/login">Log In</a>
            <a href="{{ siteURI }}/register">Sign Up</a>
        {% endif %}
    </section>
    <!-- This may be added in later
    <section id="siteSearch">
        <form method="GET" action="{{ siteURI }}/search ">
            <input type="text" name="search_string" placeholder="Search the site..." />
            <input type="submit" name="submit" value="Search" />
        </form>
    </section>
    -->
    <nav>
        <a href="{{ siteURI }}">Home</a>
        <a href="{{ siteURI }}/aboutme">About Me</a>
        <a href="{{ siteURI }}/products">Products</a>
        <a href="{{ siteURI }}/posts">Blog</a>
        <a href="#5">Contact Me</a>

        <a href="" class="social-button">F</a>
        <a href="" class="social-button">T</a>
        <a href="" class="social-button">G</a>
    </nav>
    <div class="clearFloat"></div>
</header>