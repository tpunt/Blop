<header>
    <figure>
        <h1><a href="{{ siteURI }}">Lindsey's <sup>PT</sup></a></h1>
        <figcaption>The Home Training Specialist</figcaption>
    </figure>
    <section id="account">
        {% if loggedIn %}
        <a href="{{ siteURI }}/account">Account</a>
        <a href="{{ siteURI }}/account/logout">Log Out</a>
        {% else %}
        <a href="{{ siteURI }}/login">Log In</a>
        <a href="{{ siteURI }}/register">Sign Up</a>
        {% endif %}
        <a href="{{ siteURI }}/basket">Basket</a>
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
        <ul>
            <li><a href="{{ siteURI }}">Home</a></li>
            <li><a href="{{ siteURI }}/aboutme">About Me</a></li>
            <li><a href="{{ siteURI }}/products">Products</a></li>
            <li><a href="{{ siteURI }}/posts">Blog</a></li>
            <li><a href="#5">Contact Me</a></li>
        </ul>
    </nav>
    <div class="clearFloat"></div>
</header>