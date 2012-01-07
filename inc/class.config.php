<?php

// Classes of the engine
define('CLASS_VIEW',            'View');
define('CLASS_BASE',            'Base');
define('CLASS_BDD',             'BddMongoDB');
define('CLASS_CORE_MESSAGE',    'Coremessage');
define('CLASS_EMAIL',           'Email');
define('CLASS_COMPONENT',       'Component');
define('CLASS_CONTROLLER',      'Controller');
define('CLASS_DEBUG',           'Debug');
define('CLASS_INSTALL',         'Install');
define('CLASS_CSS',             'Css');
define('CLASS_CONTENT_MANAGER', 'ContentManager');
define('CLASS_SIMPLE_CM',       'SimpleContentManager');
define('CLASS_PDF',             'Pdf');
define('CLASS_LESS',            'Less_php');
define('CLASS_MEDIA',           'Media');
define('CLASS_YOUTUBE',         'Youtube');
define('CLASS_UPLOAD',          'Upload');
define('CLASS_WATERMARK',       'Watermark');
define('CLASS_CALENDAR',        'Calendar');
define('CLASS_MEMCACHE',        'MemcacheInstance');
define('CLASS_QR',              'QR');

/* -----------------------------------------------------------------------------
  ~ Aenyhm's thoughts ~

  I don't think declaring all these constants is relevant...

  Why not just create a file (php|xml) which references the classes to load ?
----------------------------------------------------------------------------- */