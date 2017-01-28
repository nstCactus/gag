var secrets = require('./_secrets');

module.exports = {
// Common options
    options: {
        localPath:     '../www',
        share:         {
            'media':                   'media',
            'bo-app-tmp-logs':         'bo/app/tmp/logs',
            'bo-app-tmp-sessions':     'bo/app/tmp/sessions',
            'bo-logs':                 'bo/logs',
            'bo-tmp':                  'bo/tmp',
            'app-tmp-logs':            'app/tmp/logs',
            'logs':                    'logs',
            'lhs_remote_mysql_backup': 'lhs_remote_mysql_backup',
        },
        create:        [
            'app/tmp',
            'app/tmp/cache',
            'app/tmp/smarty',
            'app/tmp/smarty/compile',
            'bo/app/tmp',
            'bo/app/tmp/cache',
            'resize',
        ],
        makeWriteable: [
            'app/tmp',
            'app/tmp/cache',
            'app/tmp/smarty',
            'app/tmp/smarty/compile',
            'bo/app/tmp',
            'bo/app/tmp/cache',
            'resize',
        ]
    },

    // Production
    'preprod': secrets.deployment.preprod,
};
