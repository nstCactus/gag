'use strict';
module.exports = function (grunt)
{
    // Loaded to show each task duration
    require('time-grunt')(grunt);

    // Charger la configuration spécifique à l'environnement
    var env = require('./grunt_config/_project.js');

    // Project and plugins configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        env: env,

        // Notifications
        notify_hooks: {
            options: {
                enabled: true,
                title:   '<%= pkg.name %>' // defaults to the name in package.json, or will use project directory's name
            }
        },
        notify:       {
            dev:  {options: {message: 'dev task complete!'}},
            dist: {options: {message: 'dist task complete!'}}
        }
    });


    // LESS
    grunt.config.set('less', require('./grunt_config/less'));
    grunt.loadNpmTasks('grunt-contrib-less');


    // Autoprefixer
    grunt.config.set('autoprefixer', require('./grunt_config/autoprefixer'));
    grunt.loadNpmTasks('grunt-autoprefixer');


    // Uglify
    grunt.config.set('uglify', require('./grunt_config/uglify'));
    grunt.loadNpmTasks('grunt-contrib-uglify');


    // JS hint
    grunt.config.set('jshint', require('./grunt_config/jshint'));
    grunt.loadNpmTasks('grunt-contrib-jshint');


    // Watch
    grunt.config.set('watch', require('./grunt_config/watch'));
    grunt.loadNpmTasks('grunt-contrib-watch');


    // Notify
    grunt.config.set('notify', require('./grunt_config/notify'));
    grunt.config.set('notify_hooks', {options: {title: '<%= pkg.name %>'}});
    grunt.loadNpmTasks('grunt-notify');
    grunt.task.run('notify_hooks');


    // Copy
    grunt.config.set('copy', require('./grunt_config/copy'));
    grunt.loadNpmTasks('grunt-contrib-copy');


    // Deploy
    grunt.config.set('ssh-deploy-release', require('./grunt_config/ssh-deploy-release'));
    grunt.loadNpmTasks('grunt-ssh-deploy-release');


    // Declare tasks
    // =============

    // Documentation
    grunt.registerTask('doc', ['markdown:readme']);


    // Development
    grunt.registerTask('dev', [
        'less:dev',
        'less:devBo',
        'uglify:dev',
        'notify:dev',
        'copy:components',
        'copy:layouts',
    ]);


    // Dist
    grunt.registerTask('dist', [
        'less:dist',
        'less:devBo',
        'autoprefixer:dist',
        'uglify:dist',
        'notify:dist',
        'copy:components',
        'copy:layouts',
    ]);


    // Default
    grunt.registerTask('default', [
        'dev',
        'watch'
    ]);
};
