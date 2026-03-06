<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Paths extends BaseConfig
{
    /**
     * ---------------------------------------------------------------
     * SYSTEM DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "system" directory.
     * Include the path if the directory is not in the same directory
     * as this file.
     */
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * ---------------------------------------------------------------
     * APPLICATION DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * If you want this front controller to use a different "app"
     * directory then the default one you can set its name here. The
     * directory can also be renamed or relocated anywhere on your
     * server. If you do, use an absolute (full) server path.
     * For more info please see the user guide:
     *
     * https://codeigniter.com/user_guide/general/managing_apps.html
     */
    public string $appDirectory = 'app';

    /**
     * ---------------------------------------------------------------
     * WRITABLE DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "writable" directory.
     * The writable directory allows you to group all directories that
     * need write permission to a single place that can be tucked away
     * for security, keeping it out of the app and/or system directories.
     */
    public string $writableDirectory = 'writable';

    /**
     * ---------------------------------------------------------------
     * TESTS DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "tests" directory.
     * The writable directory allows you to group all directories that
     * need write permission to a single place that can be tucked away
     * for security, keeping it out of the app and/or system directories.
     */
    public string $testsDirectory = 'tests';

    /**
     * ---------------------------------------------------------------
     * VIEW DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the view files used by your application. By default
     * this is in `app/Views`. It can be relocated anywhere in your
     * application's namespace.
     *
     * NOTE: If you are using the "auto-discovery" feature of the
     * new namespace, you should move this out of the app/ directory
     * and into the namespace root, or the views may not load correctly.
     */
    public string $viewDirectory = __DIR__ . '/../Views';
}
