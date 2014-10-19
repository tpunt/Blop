<header>
    <figure>
        <h1><a href="{{ baseURI }}">Lindsey's <sup>PT</sup></a></h1>
        <figcaption>The Home Training Specialist</figcaption>
    </figure>
    <section id="siteSearch">
        <form method="GET" action="{{ baseURI }}/search ">
            <input type="text" name="search_string" placeholder="Search the site..." />
            <input type="submit" name="submit" value="Search" />
        </form>
    </section>
    <nav>
        <ul>
            <li><a href="{{ baseURI }}">Home</a></li>
            <li><a href="{{ baseURI }}/aboutme">About Me</a></li>
            <li><a href="#3">Products</a></li>
            <li><a href="#4">Blog</a></li>
            <li><a href="#5">Contact Me</a></li>
        </ul>
    </nav>
    <section id="account">
        {% if loggedIn %}
        <a href="{{ baseURI }}/account">Account</a>
        <a href="{{ baseURI }}/account/logout">Log Out</a>
        {% else %}
        <a href="{{ baseURI }}/login">Log In</a>
        <a href="{{ baseURI }}/register">Sign Up</a>
        {% endif %}
    </section>
    <div class="clearFloat"></div>
</header>