module.exports = function (grunt) {
    const SRC_DIRECTORY    = 'src';
    const PUBLIC_DIRECTORY = SRC_DIRECTORY + '/public';
    const TEST_DIRECTORY   = 'tests';

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        php: {
            dist: {
                options: {
                    hostname: 'localhost',
                    port: 8000,
                    base: PUBLIC_DIRECTORY,
                    open: true,
                    keepalive: true
                }
            }
        },
        phpcs: {
            application: {
                src: [SRC_DIRECTORY + '/**/*.php']
            },
            options: {
                bin: 'vendor/bin/phpcs',
                standard: 'PSR2'
            }
        },
        phpunit: {
            classes: {
                dir: TEST_DIRECTORY
            },
            options: {
                bin: 'vendor/bin/phpunit',
                dir : TEST_DIRECTORY
            }
        }
    });

    // Load the plugin that provides the "php" task.
    grunt.loadNpmTasks('grunt-php');
    // Load the plugin that provides the "phpcs" task.
    grunt.loadNpmTasks('grunt-phpcs');
    // Load the plugin that provides the "phpunit" task.
    grunt.loadNpmTasks('grunt-phpunit');

    grunt.registerTask('validate', ['phpcs', 'phpunit']);
};