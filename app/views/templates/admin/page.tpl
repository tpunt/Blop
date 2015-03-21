<h1>Update Page Information</h1>

<form class="inputForm" action="{{ baseURI }}/{{ superRoute }}/{{ subRoute }}/edit?page={{ page.getPageName }}" method="POST">
    <div>
        <label for="pageTitle">Page Title:</label> 
        <input type="text" name="pageTitle" id="pageTitle" value="{{ page.getPageTitle }}" /><br />
    </div>

    {% for content in page.getAllPageContent %}
    <div>
        <label for="{{ content.ContentID }}">Section {{ content.ContentID }}</label>
        <input type="hidden" name="content[]" value="{{ content.ContentID }}" />
        <textarea id="{{ content.ContentID }}" name="content[]" class="contentArea">{{ content.getContent }}</textarea><br />
    </div>
    {% endfor %}
    <div>
        <input type="submit" name="updateContent" value="Update Content" />
    <div>
</form>