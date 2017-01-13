/**
 * @author  Yohann Bianchi <yohann.b@lahautesociete.com>
 * @date    04/12/2015 - 18:01
 * @copyright 2015 La Haute Société - http://www.lahautesociete.com/
 */
var pngcrush = require('imagemin-pngcrush');

module.exports = {
    options: {
        optimizationLevel: 5,
        use: [
            pngcrush({reduce: true}),
        ]
    },
    default: {
        files: [{
            expand: true,
            cwd: '<%= env.imageSrc %>',
            src: [ '**/*.{png,jpg,gif,jpeg}' ],
            dest: '<%= env.imageDest %>',
        }]
    },
    sprites: {
        files: [{
            expand: true,
            cwd: '<%= env.spriteDest %>',
            src: [ '_generated_sprite.png' ],
            dest: '<%= env.spriteDest %>'
        }]
    }
};
