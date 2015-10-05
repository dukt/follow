# Follow for Craft CMS

A simple plugin to connect to Follow's API.

-------------------------------------------


## Installation

1. Download the latest release of the plugin
2. Drop the `follow` plugin folder to `craft/plugins`
3. Install Follow from the control panel in `Settings > Plugins`


## Templating


### Activity

Recent entries from users you are following.

    {% if not currentUser %}
        <p>{{ 'You need to <a href="{url}">login</a> in order to see the activity of users you follow.'|t({ url: url('follow/login') })|raw }}</p>
    {% else %}
        {% set followingUsers = craft.follow.getFollowing( user.id ) %}

        {% set followingUserIds = [] %}
        {% for followingUser in followingUsers %}
            {% set followingUserIds = followingUserIds|merge([ followingUser.id ]) %}
        {% endfor %}

        {% if followingUserIds|length > 0 %}

            {% set entries = craft.entries.authorId(followingUserIds).find() %}

            {% if entries|length %}
                {% for entry in entries %}
                    <div class="media">
                        <div class="media-left text-center">

                            {% if entry.author.photoUrl %}
                                {% set photoUrl = entry.author.photoUrl(80) %}
                            {% else %}
                                {% set photoUrl = resourceUrl('images/user.gif') %}
                            {% endif %}

                            <img src="{{ photoUrl }}" width="80" class="img-circle" />

                            <p>{{ entry.author.fullName }}</p>

                        </div>

                        <div class="media-body">

                            <h4 class="media-heading">{{ entry.title }}</h4>

                            <p>
                                <small>{{ entry.postDate.nice }}</small>
                            </p>

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, unde molestias odit mollitia sint. Similique, nesciunt, sunt, magnam enim asperiores totam consequuntur ratione nemo quam ut vitae accusantium blanditiis esse.</p>

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, unde molestias odit mollitia sint. Similique, nesciunt, sunt, magnam enim asperiores totam consequuntur ratione nemo quam ut vitae accusantium blanditiis esse.</p>

                        </div>
                    </div>

                    <hr>
                {% endfor %}
            {% else %}
                <p>{{ "Start following some users to see their recent entries."|t }}</p>
            {% endif %}
        {% else %}
            <p>{{ "Start following some users to see their recent entries."|t }}</p>
        {% endif %}

    {% endif %}


### Following

Users that you are following.

    {% if not currentUser %}
        <p>You need to <a href="{{url('follow/login')}}">login</a> in order to see the users you follow.</p>
    {% else %}
        {% set users = craft.follow.getFollowing() %}

        {% if users|length > 0 %}

            <p>You are following {{users|length}} users.</p>

            <div class="row">
                {% for user in users %}
                    <div class="col-md-4">
                        {% include 'follow/_user' with { user: user } %}
                    </div>
                {% endfor %}
            </div>

        {% else %}
            <p>{{ "You are not following anyone."|t }}</p>
        {% endif %}

    {% endif %}


### Followers

Users that are following you.

    {% if not currentUser %}
        <p>{{ 'You need to <a href="{url}">login</a> in order to see you followers.'|t({ url: url('follow/login') })|raw }}</p>
    {% else %}
        {% set users = craft.follow.getFollowers(currentUser.id) %}

        {% if users %}

            <p>{{ "You have {count} followers."|t({ count: users|length }) }}</p>

            <div class="row">
                {% for user in users %}
                    <div class="col-md-4">
                        {% include 'follow/_user' with { user: user } %}
                    </div>
                {% endfor %}
            </div>

        {% else %}
            <p>{{ "No one is following you." }}</p>
        {% endif %}
    {% endif %}

### user.html

    {% set followers = craft.follow.getFollowers(user.id) %}

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-4">
                            {% if user.photoUrl %}
                                {% set photoUrl = user.photoUrl %}
                            {% else %}
                                {% set photoUrl = resourceUrl('images/user.gif') %}
                            {% endif %}

                            <img src="{{ photoUrl }}" width="90" class="img-circle" />
                        </div>
                        <div class="col-sm-8">

                            <h5>{{ user.fullName }}</h5>

                            {% set followersCount = followers|length %}

                            {% if followersCount > 1 %}
                                <p>{{ "{count} followers"|t({ count: followersCount }) }}</p>
                            {% else %}
                                <p>{{ "{count} follower"|t({ count: followersCount }) }}</p>
                            {% endif %}

                            {% if currentUser and currentUser.id != user.id %}
                                {% if craft.follow.isFollow(user.id) %}
                                    <a class="btn btn-default btn-sm" href="{{actionUrl('follow/stopFollowing', {id:user.id})}}">{{ "Unfollow"|t }}</a>
                                {% else %}
                                    <a class="btn btn-default btn-sm btn-primary" href="{{actionUrl('follow/startFollowing', {id:user.id})}}">{{ "Follow"|t }}</a>
                                {% endif %}
                            {% else %}
                                <div class="btn btn-default btn-sm btn-primary disabled">{{ "Follow"|t }}</div>
                            {% endif %}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


## API


### FollowVariable

- isFollow($elementId)
- getFollowers($userId = null)
- getFollowing($userId = null)