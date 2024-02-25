<?php

return [
    // If disable users Can't register in the website
    // IF IN PRODUCTION CHANGE THIS TO FALSE
    'demo_enable' => true,
    // If disable users Can't register in the website
    'sucess_login_route' => 'castle.try',
    // If true means that the session can expire and will ask the authentication again
    'castle_session_can_expire' => true,
    // Castle wall middleware session time, means how long the session can be active
    'castle_wall_session_time'  => 60,
    // Castle popup theme
    // Supported themes: 'light','dark','cupcake','bumblebee','emerald','corporate','synthwave','retro','cyberpunk','valentine','halloween','garden','forest','aqua','lofi','pastel','fantasy','wireframe','black','luxury','dracula','cmyk','autumn','business','acid','lemonade','night','coffee','winter'
    'castle_theme'  => 'coffee',
];


