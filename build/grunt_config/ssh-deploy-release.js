module.exports = {
    options: {
        localPath: '../www',
        exclude:   [
            'app/tmp/logs/**',
            'bo/logs/**',
            'logs/**'
        ],
        share:     {
            'app-tmp-logs': 'app/tmp/logs',
            'bo-logs':      'bo/logs',
            'logs':         'logs',
            'media':        'media',
        }
    },

    dev: {
        options: {
            host:       '',
            username:   '',
            password:   '',
            deployPath: ''
        }
    },
};
