<?php

return array(

    // On Follow

    "follow.onfollow_label"   => "Notify me when someone starts following me",
    "follow.onfollow_message" => '{{sender.friendlyName}} has started following you.',
    "follow.onfollow_subject" => "{{sender.friendlyName}} has started following you",
    "follow.onfollow_body"    => "Hey {{recipient.friendlyName}},\n\n{{sender.friendlyName}} has started following you.",


    // On New Entry

    "follow.onnewentry_label"   => "Notify me when someone I follow posts new entries",
    "follow.onnewentry_message" => '{{sender.friendlyName}} has posted “{{entry.title}}”.',
    "follow.onnewentry_subject" => "{{sender.friendlyName}} has posted a new entry",
    "follow.onnewentry_body"    =>  "Hey {{recipient.friendlyName}},\n\n".
                                    "{{sender.friendlyName}} has posted a new entry:\n\n".
                                    '<a href="{{entry.url}}">{{entry.title}}</a>',
);