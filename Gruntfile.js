module.exports = function (grunt) {
    const SRC_DIRECTORY          = __dirname + '/src';
    const PUBLIC_DIRECTORY       = SRC_DIRECTORY + '/public';
    const TEST_DIRECTORY         = __dirname + '/tests';
    const COMPOSER_BIN_DIRECTORY = __dirname + '/vendor/bin';

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        php: {
            dist: {
                options: {
                    hostname: 'localhost',
                    port: 8000,
                    base: PUBLIC_DIRECTORY,
                    keepalive: true
                }
            }
        },
        phpcs: {
            application: {
                src: [SRC_DIRECTORY + '/**/*.php']
            },
            options: {
                bin: COMPOSER_BIN_DIRECTORY + '/phpcs',
                standard: 'PSR2'
            }
        },
        phpunit: {
            classes: {
                dir: TEST_DIRECTORY
            },
            options: {
                bin: COMPOSER_BIN_DIRECTORY + '/phpunit',
                dir : TEST_DIRECTORY,
                bootstrap: TEST_DIRECTORY + '/bootstrap.php',
                colors: true
            }
        }
    });

    // Load the plugin that provides the "php" task.
    grunt.loadNpmTasks('grunt-php');
    // Load the plugin that provides the "phpcs" task.
    grunt.loadNpmTasks('grunt-phpcs');
    // Load the plugin that provides the "phpunit" task.
    grunt.loadNpmTasks('grunt-phpunit');

    grunt.registerTask('style', ['phpcs']);
    grunt.registerTask('test', ['phpunit']);
    grunt.registerTask('run', ['php']);
};