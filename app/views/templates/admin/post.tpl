{% if post %}
<form class="inputForm" method="POST" action="{{ siteURI }}/{{ superRoute }}/{{ subRoute }}/edit?postID={{ post.getPostID }}">
{% else %}
<form class="inputForm" method="POST" action="{{ siteURI }}/{{ superRoute }}/{{ subRoute }}/create">
{% endif %}
    <div>
        <label for="postTitle">Post Title:</label>
        <input type="text" name="postTitle" id="postTitle" value="{{ post.getPostTitle }}" />
    </div>


    <div>
        <label for="postBody"> Post Body:</label>
        <textarea name="postBody" id="postBody">{{ post.getPostBody }}</textarea><br />
    </div>
    {% if post %}
    <input type="submit" name="updatePost" value="Update Post" />
    {% else %}
    <input type="submit" name="createPost" value="Create Post" />
    {% endif %}
</form>

{% if post %}
<!--<form method="POST" action="{{ siteURI }}/{{ superRoute }}/{{ subRoute }}/delete?postID={{ post.getPostID }}">
<input type="checkbox" name="confirmation" />
<input type="submit" name="confirmDeletion" value="Confirm Deletion" />
</form>-->
{% endif %}