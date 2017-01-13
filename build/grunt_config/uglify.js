/**
 * @author  Yohann Bianchi <yohann.b@lahautesociete.com>
 * @date    04/12/2015 - 14:00
 * @copyright 2015 La Haute Société - http://www.lahautesociete.com/
 */

// Liste des fichiers JS du projets
var uglifyProjectJSFiles = [
    '<%= env.srcPath %>/components/**/*.js',
    '<%= env.jsSrc %>/common/**/*.js',
];

// Liste des libs js
var uglifyLibsJSFiles = [
    '<%= env.jsSrc %>/libs/**/*.js',
];

module.exports = {
    options: {
        banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>*/\n'
    },

    // Config pour la phase de développement
    dev: {
        options: {
            compress: false,
            mangle:   false,
            beautify: true
        },
        files:   {
            '<%= env.jsDest %>/script.js':  [ uglifyLibsJSFiles, uglifyProjectJSFiles ],
            '<%= env.jsDest %>/pattern.js': '<%= env.cssSrc %>/../components/pattern/pattern.js',
        }
    },

    // Config pour le déploiement
    dist: {
        options: {
            compress: {},
            mangle:   {
                except: [ 'jQuery' ]
            },
            beautify: false
        },
        files:   {
            '<%= env.jsDest %>/script.js': [ uglifyLibsJSFiles, uglifyProjectJSFiles ],
        }
    }
};
