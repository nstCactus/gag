/**
 * @author  Yohann Bianchi <yohann.b@lahautesociete.com>
 * @date    04/12/2015 - 15:54
 * @copyright 2015 La Haute Société - http://www.lahautesociete.com/
 */

module.exports = {
    dist: {
        src: '<%= env.jsDest %>/script.js',

        options: {
            methods: [ 'debug', 'log' ],
        }
    }
};
