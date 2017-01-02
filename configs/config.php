<?php declare(strict_types = 1);

return [
    // settings
    'settings.app.name' => 'slim-example',

    'settings.displayErrorDetails' => getenv('SLIM_EXAMPLE_DISPLAY_ERRORS'),

    'settings.db.name' => getenv('SLIM_EXAMPLE_DB_NAME'),
    'settings.db.dsn' => getenv('SLIM_EXAMPLE_MONGODB_CONNECTION_STRING'),
    'settings.db.connectTimeoutMS' => 100,
    'settings.db.socketTimeoutMS' => 10000,

    'settings.logs.debug.enabled' => getenv('SLIM_EXAMPLE_DEBUG_LOG') === 'true',
    'settings.logs.path' => getenv('SLIM_EXAMPLE_LOGS_PATH'),
    'settings.providers.facebook.appId' => getenv('SLIM_EXAMPLE_FB_APP_ID'),
    'settings.providers.facebook.secret' => getenv('SLIM_EXAMPLE_FB_APP_SECRET'),

];
