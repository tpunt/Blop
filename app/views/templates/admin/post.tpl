{% if post %}
<form method="POST" action="{{ siteURI }}/{{ superRoute }}/{{ subRoute }}/edit?postID={{ post.getPostID }}">
{% else %}
<form method="POST" action="{{ siteURI }}/{{ superRoute }}/{{ subRoute }}/create">
{% endif %}
    Post Title:<br /><input type="text" name="postTitle" value="{{ post.getPostTitle }}" /><br /><br />
    Post Body:<br />
    <textarea name="postBody">{{ post.getPostBody }}</textarea><br />

    {% if post %}
    <input type="submit" name="updatePost" value="Update Post" />
    {% else %}
    <input type="submit" name="createPost" value="Create Post" />
    {% endif %}
</form>

{% if post %}
<form method="POST" action="{{ siteURI }}/{{ superRoute }}/{{ subRoute }}/delete?postID={{ post.getPostID }}">
<input type="checkbox" name="confirmation" />
<input type="submit" name="confirmDeletion" value="Confirm Deletion" />
</form>
{% endif %}