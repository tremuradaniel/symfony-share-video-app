// !!!!!!!!!!!!!!!! IMPORTANT !!!!!!!!!!!!!!!!!
// run using
// .\node_modules\.bin\encore production
// OR
// .\node_modules\.bin\encore dev --watch
let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets')
    // .addEntry('js/custom', './build/js/custom.js')
    .addStyleEntry('css/dashboard', ['./assets/css/dashboard.css'])
    .addStyleEntry('css/login', ['./assets/css/login.css'])
// .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
