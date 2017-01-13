module.exports = {

    sprite: {
        options: {
            livereload: true,
        },
        files:   [
            '<%= env.projectRoot %>/build/grunt_config/sprite.js',
            '<%= env.spriteSrc %>/**/*.png',
        ],
        tasks:   [ 'sprite', 'less:dev', 'notify:dev' ],
    },

    style: {
        options: {
            livereload: true,
        },
        files:   [
            '<%= env.projectRoot %>/build/grunt_config/less.js',
            '<%= env.srcPath %>/components/**/*.less',
            '<%= env.srcPath %>/layouts/**/*.less',
            '<%= env.cssSrc %>/*.less',
            '<%= env.cssSrc %>/**/*.less',
            '<%= env.cssSrc %>/**/**/*.less',
        ],
        tasks:   [ 'less:dev', 'autoprefixer:dist', 'notify:dev' ],
    },

    styleBo: {
        options: {
            livereload: true,
        },
        files:   [
            '<%= env.projectRoot %>/build/grunt_config/less.js',
            '<%= env.cssDest %>/../bo/css/**/*.less',
        ],
        tasks:   [ 'less:devBo', 'notify:dev' ],
    },

    script: {
        options: {
            livereload: true,
        },
        files:   [
            '<%= env.projectRoot %>/build/grunt_config/uglify.js',
            '<%= env.jsSrc %>*.js',
            '<%= env.jsSrc %>/*.js',
            '<%= env.srcPath %>/components/**/*.js',
            '<%= env.jsSrc %>/**/*.js',
        ],
        tasks:   [ 'uglify:dev', 'notify:dev' ],
    },

    readme: {
        options: {
            livereload: true,
        },
        files:   [
            '<%= env.projectRoot %>/build/grunt_config/markdown.js',
            '<%= env.projectRoot %>/readme.md'
        ],
        tasks:   [ 'markdown:readme' ]
    },

    copyComponents: {
        options: {
            livereload: true,
        },
        files:   [
            '<%= env.projectRoot %>/src/components/**/*'
        ],
        tasks:   [ 'copy:components' ]
    },

    copyLayouts: {
        options: {
            livereload: true,
        },
        files:   [
            '<%= env.projectRoot %>/src/layouts/**/*'
        ],
        tasks:   [ 'copy:layouts' ]
    },
};
