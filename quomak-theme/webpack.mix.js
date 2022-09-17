
let mix = require('laravel-mix');

mix.js('src/scripts/libs/index.js', 'public/scripts/libs.js');
    mix.js('src/scripts/app/index.js', 'public/scripts/app.js');
    mix.js('src/scripts/app/guest.js', 'public/scripts/guest.js');
    mix.js('src/scripts/app/user.js', 'public/scripts/user.js');
    mix.js('src/scripts/app/administrator.js', 'public/scripts/administrator.js');
    mix.js('src/scripts/app/subscriber.js', 'public/scripts/subscriber.js');



mix.sass('src/styles/libs/index.scss', 'public/styles/libs.css')
.sass('src/styles/app/index.scss', 'public/styles/app.css');