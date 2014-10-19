<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta charset="utf-8" />

        <title>{{ pageTitle }}</title>

        <link rel="stylesheet" type="text/css" href="{{ baseURI }}/public/css/global.css" />
        <link rel="stylesheet" type="text/css" href="{{ baseURI }}/public/css/index.css" />

        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="{{ baseURI }}/public/javascript/beaverslider.js"></script>
        <script src="{{ baseURI }}/public/javascript/beaverslider-effects.js"></script>
        <script src="{{ baseURI }}/public/javascript/beaverslider-config.js"></script>
    </head>
    <body>
        <aside id="socialSideBar">
            <section class="socialBox">F</section>
            <section class="socialBox">T</section>
            <section class="socialBox">G</section>
        </aside>

        {% include 'global/header.tpl' %}

        <section id="mainframe">
            <div id="imageSlider"></div>

            <section class="leftBox">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque consectetur elit et mauris tincidunt cursus. Phasellus ut quam est. Aenean bibendum sem iaculis tortor ornare, eget dignissim neque tincidunt. Sed mi lectus, maximus accumsan placerat finibus, volutpat ac ipsum. Mauris mattis eu dui ut congue. Nam neque lectus, varius eu lorem sit amet, rutrum tincidunt velit.
                </p>
                <p class="marginTop">
                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec pharetra est in tincidunt imperdiet. Aliquam tempus dignissim neque, ut molestie mauris elementum at. Pellentesque consequat sagittis augue, quis placerat leo tincidunt quis. Donec a diam id quam volutpat pulvinar a eu velit.
                </p>
            </section>

            <!-- <aside id="blogRoll">
                content here
            </aside> -->

            <section class="rightBox marginTop">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque consectetur elit et mauris tincidunt cursus. Phasellus ut quam est. Aenean bibendum sem iaculis tortor ornare, eget dignissim neque tincidunt. Sed mi lectus, maximus accumsan placerat finibus, volutpat ac ipsum. Mauris mattis eu dui ut congue. Nam neque lectus, varius eu lorem sit amet, rutrum tincidunt velit.
                </p>
                <p class="marginTop">
                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec pharetra est in tincidunt imperdiet. Aliquam tempus dignissim neque, ut molestie mauris elementum at. Pellentesque consequat sagittis augue, quis placerat leo tincidunt quis. Donec a diam id quam volutpat pulvinar a eu velit.
                </p>
            </section>

            <div class="clearFloat"></div>

            <section class="centerBox marginTop">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque consectetur elit et mauris tincidunt cursus. Phasellus ut quam est. Aenean bibendum sem iaculis tortor ornare, eget dignissim neque tincidunt. Sed mi lectus, maximus accumsan placerat finibus, volutpat ac ipsum. Mauris mattis eu dui ut congue. Nam neque lectus, varius eu lorem sit amet, rutrum tincidunt velit.
                </p>
                <p class="marginTop">
                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec pharetra est in tincidunt imperdiet. Aliquam tempus dignissim neque, ut molestie mauris elementum at. Pellentesque consequat sagittis augue, quis placerat leo tincidunt quis. Donec a diam id quam volutpat pulvinar a eu velit.
                </p>
            </section>

            <div class="clearFloat"></div>
        </section>

        {% include 'global/footer.tpl' %}
    </body>
</html>