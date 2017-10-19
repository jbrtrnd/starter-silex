<?php

// Get the Composer generated autoloader (from vendors directory)
$loader = require DIR_VENDORS . '/autoload.php';

/**
 * Add all directories located in the DIR_MODULES to autoloader by prefixing the namespace with the directory name
 * TODO : in production environment, the module list should be in a static file to increase performance
 */
foreach (scandir(DIR_MODULES) as $module) {
    if (is_dir(DIR_MODULES . '/' . $module) && $module !== '.' && $module !== '..') {
        $loader->addPsr4($module . '\\', DIR_MODULES . '/' . $module . '/src');
    }
}

return $loader;
