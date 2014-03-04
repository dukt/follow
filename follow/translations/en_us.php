<?php

return array(

    // On Follow

    "follow.onfollow_label"   => "Notify me when someone starts following me",
    "follow.onfollow_message" => "{{contextUser.friendlyName}} has started following you",
    "follow.onfollow_subject" => "{{contextUser.friendlyName}} has started following you",
    "follow.onfollow_body"    => "Hey {{user.friendlyName}},\n\n{{contextUser.friendlyName}} has started following you.",


    // On New Entry

    "follow.onnewentry_label"   => "Notify me when someone I follow posts new entries",
    "follow.onnewentry_message" => "{{contextUser.friendlyName}} has posted a new entry",
    "follow.onnewentry_subject" => "{{contextUser.friendlyName}} has posted a new entry",
    "follow.onnewentry_body"    => "Hey {{user.friendlyName}},\n\n{{contextUser.friendlyName}} has posted a new entry:\n\n"."{{(entry.url is defined ? entry.url : 'Entry ID:'~entry.id)}}",
);