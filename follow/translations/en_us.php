<?php

return array(

    // On Follow

    "follow.onfollow_heading"    => "When someone gets followed:",
    "follow.onfollow_subject"    => "You have a new follower",
    "follow.onfollow_body"    => "{{user.friendlyName}} has started following you.",


    // On New Entry

    "follow.onnewentry_heading"    => "When someone I follow posts a new entry:",
    "follow.onnewentry_subject"    => "Someone you follow has posted a new entry",
    "follow.onnewentry_body"    => "{{user.friendlyName}} has posted a new entry:\n\n".
                                    "{{(entry.url is defined ? entry.url : 'Entry ID:'~entry.id)}}",
);