module.exports = {
    dev:   {
        options: {
            paths:             ['<%= env.webRoot %>/static/'],
            sourceMap:         true,
            sourceMapFilename: '<%= env.cssDest %>/style.css.map',
            sourceMapURL:      'style.css.map',
            sourceMapRootpath: './',
            outputSourceFiles: true,
            compress:          false
        },
        files:   {
            '<%= env.cssDest %>/style.css':   '<%= env.cssSrc %>/bootstrap.less',
            '<%= env.cssDest %>/pattern.css': '<%= env.cssSrc %>/../layouts/pattern/pattern.less',
        }
    },
    devBo: {
        options: {
            paths:             ['<%= env.webRoot %>/static/'],
            sourceMap:         false,
            outputSourceFiles: true,
            compress:          false
        },
        files:   {
            '<%= env.cssDest %>/../../bo/css/style.css': '<%= env.cssDest %>/../../bo/css/main.less',
        }
    },
    dist:  {
        options: {
            paths:    ['<%= env.webRoot %>/static/'],
            compress: {}
        },
        files:   {
            '<%= env.cssDest %>/style.css':              '<%= env.cssSrc %>/bootstrap.less',
            '<%= env.cssDest %>/../../bo/css/style.css': '<%= env.cssDest %>/../../bo/css/main.less',
        }
    }
};
