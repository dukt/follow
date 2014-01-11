<?php

return array(

    // On Follow

    "follow.onfollow_settings_label"   => "Notify me when someone starts following me",
    "follow.onfollow_heading"          => "When someone gets followed:",
    "follow.onfollow_subject"          => "You have a new follower",
    "follow.onfollow_body"             => "Hey {{user.friendlyName}},\n\n{{contextUser.friendlyName}} has started following you.",


    // On New Entry

    "follow.onnewentry_settings_label" => "Notify me when someone I follow posts new entries",
    "follow.onnewentry_heading"        => "When someone I follow posts a new entry:",
    "follow.onnewentry_subject"        => "Someone you follow has posted a new entry",
    "follow.onnewentry_body"           => "Hey {{user.friendlyName}},\n\n{{contextUser.friendlyName}} has posted a new entry:\n\n"."{{(entry.url is defined ? entry.url : 'Entry ID:'~entry.id)}}",
);