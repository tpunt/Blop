<table>
    <tr>
        <th colspan="3" class="th1">Page Name</th>
    </tr>
    {% for page in pages %}
    <tr>
        <td>{{ page.getPageTitle }}</td>
        <td class="btn view"><a href="{{ siteURI }}/{{ page.getPageName }}">View</a></td>
        <td class="btn edit"><a href="{{ siteURI }}/{{ superRoute }}/page?page={{ page.getPageName }}">Edit</a></td>
    </tr>
    {% endfor %}
</table>