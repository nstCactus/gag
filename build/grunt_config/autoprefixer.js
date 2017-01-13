module.exports = {
    options: {
        browsers: [ 'last 1 version', '> 5%' ]
    },
    dist: {
        expand: true,
        flatten: true,
        src: '<%= env.cssDest %>/style.css',
        dest: '<%= env.cssDest %>',
        map: true,
    }
};
