<?php // -->
require_once __DIR__ . '/vendor/autoload.php';

// initialize and run the worker, set up
// required paths and load up default database
Eve\Framework\Index::i(__DIR__, 'Eve')
// set default paths
->defaultPaths()
// set default database
->defaultDatabases()
// run the worker
->work();