#!/bin/bash

for VERSION in "$@"

do

# Create Info.php with plugin version constant

cat > Source/follow/Info.php << EOF
<?php

namespace Craft;

define('FOLLOW_VERSION', '$VERSION');

EOF

done
