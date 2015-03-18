<h2>Update Page Information</h2>

<form action="{{ baseURI }}/{{ superRoute }}/{{ subRoute }}/edit?page={{ page.getPageName }}" method="POST">
    <span>Page Title:</span> <input type="text" name="pageTitle" value="{{ page.getPageTitle }}" /><br />

    {% for content in page.getAllPageContent %}
    <input type="hidden" name="content[]" value="{{ content.ContentID }}" />
    <textarea name="content[]" class="contentArea">{{ content.getContent }}</textarea><br />
    {% endfor %}

    <input type="submit" name="updateContent" value="Update Content" />
</form>