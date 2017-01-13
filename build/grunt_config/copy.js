module.exports = {
    components: {
        files: [
            {
                expand: true,
                cwd: '../src/components/',
                src: ['**/*.tpl', '**/*.json'],
                dest: '../www/app/views/elements/components',
                dot: true
            }
        ]
    },
    layouts: {
        files: [
            {
                expand: true,
                cwd: '../src/layouts/',
                src: ['**/*.tpl', '**/*.json'],
                dest: '../www/app/views/layouts',
                dot: true
            }
        ]
    }
};
