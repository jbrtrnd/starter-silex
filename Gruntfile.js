module.exports = function (grunt) {
    const SRC_DIRECTORY = 'src';

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        php: {
            dist: {
                options: {
                    hostname: 'localhost',
                    port: 8000,
                    base: SRC_DIRECTORY,
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
        }
    });

    // Load the plugin that provides the "php" task.
    grunt.loadNpmTasks('grunt-php');
    // Load the plugin that provides the "phpcs" task.
    grunt.loadNpmTasks('grunt-phpcs');
};