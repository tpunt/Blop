<table id="postsTable">
    <tr>
        <th colspan="3" class="th1">Post Name</th>
        <th class="th2 btn">
            <a href="{{ siteURI }}/{{ superRoute }}/post" id="newPostButton">New</a>
        </th>
    </tr>
    {% if posts %}
        {% for post in posts %}
        <tr>
            <td>{{ post.getPostTitle }}</td>
            {% if post.getPublishStatus %}
            <td class="btn view"><a href="{{ siteURI }}/post/{{ post.getPostID }}">View</a></td>
            {% else %}
            <td class="btn view"><a href="{{ siteURI }}/post/{{ post.getPostID }}">Preview</a></td>
            {% endif %}
            <td class="btn delete"><a href="{{ siteURI }}/{{ superRoute }}/post/delete?postID={{ post.getPostID }}" class="deletePost">Delete</a></td>
            <td class="btn edit"><a href="{{ siteURI }}/{{ superRoute }}/post?postID={{ post.getPostID }}">Edit</a></td>
        </tr>
        {% endfor %}
    {% else %}
    <tr>
        You have made no blog posts yet!
    </tr>
    {% endif %}
</table>