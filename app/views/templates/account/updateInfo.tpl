<form action="{{ siteURI }}/{{ superRoute }}/updateInfo/updateGeneralInfo" method="POST">
    <label for="fname">Forename:</label> <input type="text" id="fname" name="forename" value="{{ user.getForename }}" />
    <br />
    <label for="sname">Surname:</label> <input type="text" id="sname" name="surname" value="{{ user.getSurname }}" />
    <br /><br />
    <input type="submit" name="submit" value="Update General Information" />
</form>

{% if updateGeneralInfoError %}
    <p class="error">{{ updateGeneralInfoError }}</p>
{% endif %}

<br /><br />

<form action="{{ siteURI }}/{{ superRoute }}/updateInfo/updateSensitiveInfo" method="POST">
    <label for="email">Email:</label> <input type="text" id="email" name="email" value="{{ user.getEmail }}" />
    <br />
    <label for="pws">New Password:</label> <input type="password" id="pws" name="pws" />
    <br />
    <label for="rpws">Repeat New Password:</label> <input type="password" id="rpws" name="rpws" />
    <br /><br />
    <label for="current_pws">Current Password:</label> <input type="password" id="current_pws" name="current_pws" />
    <br /><br />
    <input type="submit" name="submit" value="Update Sensitive Information" />
</form>

{% if updateSensitiveInfoError %}
    <p class="error">{{ updateSensitiveInfoError }}</p>
{% endif %}