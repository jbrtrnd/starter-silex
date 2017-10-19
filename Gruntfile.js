module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        phpcs: {
            application: {
                src: ['src/**/*.php']
            },
            options: {
                bin: 'vendor/bin/phpcs',
                standard: 'PSR2'
            }
        }
    });

    // Load the plugin that provides the "phpcs" task.
    grunt.loadNpmTasks('grunt-phpcs');

    // Default task(s).
    grunt.registerTask('default', ['phpcs']);
};