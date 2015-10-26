<?php //-->
require_once __DIR__ . '/vendor/autoload.php';

// we're going to setup virtual server so
// jobs and models will not loose it's original scope
Eve\Framework\Index::i(__DIR__, 'Eve')
// set default paths
->defaultPaths()
// set default database
->defaultDatabases()
->work();