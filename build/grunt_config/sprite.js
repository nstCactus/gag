/**
 * @author  Yohann Bianchi <yohann.b@lahautesociete.com>
 * @date    04/12/2015 - 13:59
 * @copyright 2015 La Haute Société - http://www.lahautesociete.com/
 */

var spriteFilenamePictos = '_generated_sprite_pictos.png';

module.exports = {
    // sprite pictos
    default: {
        src:         [
            '<%= env.spriteSrc %>/**/*.png'
        ],
        cssTemplate: '<%= env.projectRoot %>/build/grunt_config/sprite-pictos.less.handlebars',
        dest:        '<%= env.spriteDest %>/' + spriteFilenamePictos,
        destCss:     '<%= env.cssSrc %>/generated_sprite/_generated_sprite_pictos.less',
        padding:     4,
        imgPath:     '../images/' + spriteFilenamePictos
    }
};
