/**
 * @author  Yohann Bianchi <yohann.b@lahautesociete.com>
 * @date    04/12/2015 - 14:01
 * @copyright 2015 La Haute Société - http://www.lahautesociete.com/
 */

module.exports = {
    options: {
        jshintrc: '<%= env.projectRoot %>/.jshintrc',
        reporter: require('jshint-stylish'),
        force:    true
    },
    all:     [
        '../gruntfile.js',
        '<%= env.jsSrc %>/components/**/*.js',
        '!<%= env.jsSrc %>/libs/**/*.*',
    ]
};
