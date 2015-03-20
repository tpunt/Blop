<table>
    <tr>
        <th class="th1">Page Name</th>
        <th class="th2">Page URL</th>
        <th class="th3">Page Title</th>
    </tr>
    {% for page in pages %}
    <tr>
        <td>{{ page.getPageName }}</td>
        <td><a href="{{ siteURI }}/{{ page.getPageName }}">{{ page.getPageName }}</a></td>
        <td><a href="{{ siteURI }}/{{ superRoute }}/page?page={{ page.getPageName }}">{{ page.getPageTitle }}</a></td>
    </tr>
    {% endfor %}
</table>