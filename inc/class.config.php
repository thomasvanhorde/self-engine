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

  Replace this by an autoload stack will increase performances and remove those
  useless declarations, don't you think? Like below.

  PHP5.3+ way:

  spl_autoload_register(function ($className) {
    require_once sprintf('class/%s.php', $className);
  });

  Or for older versions if you want to keep the compatibility (but keep in mind
  that PHP5.3 is 2x much faster than PHP5.2 ;-)):

  function __autoload($className) {
    require_once sprintf('class/%s.php', $className);
  }

  Or combine it with the ClassLoader file, but I do not think that we need to
  define all these prefixes.
----------------------------------------------------------------------------- */