var projectRoot = '..';
var webRoot     = projectRoot + '/www';
var destPath    = webRoot + '/static';
var srcPath     = projectRoot + '/src';

module.exports = {
    projectRoot: projectRoot,
    webRoot:     webRoot,
    destPath:    destPath,
    srcPath:     srcPath,

    jsSrc:       srcPath + '/scripts',
    jsDest:      destPath + '/scripts',

    cssSrc:      srcPath + '/styles',
    cssDest:     destPath + '/styles',

    imageSrc:    srcPath + '/images',
    imageDest:   destPath + '/images',

    spriteSrc:   srcPath + '/sprites',
    spriteDest:  destPath + '/images',
};
