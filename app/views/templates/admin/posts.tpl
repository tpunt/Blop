<table id="postsDisplayTable">
    <tr>
        <th colspan="4" class="th1">Post Name</th>
    </tr>
    {% for post in posts %}
    <tr>
        <td>{{ post.getPostTitle }}</td>
        <td class="btn view"><a href="{{ siteURI }}/post/{{ post.getPostID }}">View</a></td>
        <td class="btn delete"><a href="{{ siteURI }}/{{ superRoute }}/post/delete?postID={{ post.getPostID }}" class="deletePost">Delete</a></td>
        <td class="btn edit"><a href="{{ siteURI }}/{{ superRoute }}/post?postID={{ post.getPostID }}">Edit</a></td>
    </tr>
    {% endfor %}
</table>