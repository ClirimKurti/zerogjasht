'use strict';

// Variables
const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const plumber = require('gulp-plumber');
const rename = require('gulp-rename');
const babel = require('gulp-babel');
const csso = require('gulp-csso');
const csscomb = require('gulp-csscomb');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const cleanCss = require('gulp-clean-css');
const sftp = require('gulp-sftp-up4');
const svg_sprite = require('gulp-svg-sprite');
const svg_min = require('gulp-svgmin');
const svg_cheerio = require('gulp-cheerio');
const replace = require('gulp-replace');
const tinypng = require('gulp-tinypng');
const webp = require('gulp-webp');
const spritesmith = require('gulp.spritesmith');

// TEMPLATE CONFIG HERE
const theme_dir = __dirname.split('/').pop();

const sftp_host = "";
const sftp_user = "";
const sftp_pass = "";
// END

// Remote Path
let pathCss = 'wp-content/themes/'+theme_dir+'/assets/app/css/';
let pathJs = 'wp-content/themes/'+theme_dir+'/assets/app/js/';
let pathImg = 'wp-content/themes/'+theme_dir+'/assets/app/img/';
let pathSvg = 'wp-content/themes/'+theme_dir+'/assets/app/svg/';

// JavaScript
gulp.task('javascript', function () {
    if(sftp_host) {
        return gulp.src([
            './assets/dev/js/main.js'])
            .pipe(babel({
                presets: ['@babel/env']
            }))
            .pipe(gulp.dest('./assets/app/js'))
            .pipe(uglify())
            .pipe(concat('main.min.js'))
            .pipe(gulp.dest('./assets/app/js'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathJs
            }));
    } else {
        return gulp.src([
            './assets/dev/js/main.js'])
            .pipe(babel({
                presets: ['@babel/env']
            }))
            .pipe(gulp.dest('./assets/app/js'))
            .pipe(uglify())
            .pipe(concat('main.min.js'))
            .pipe(gulp.dest('./assets/app/js'))
    }

});

// Return javascript
gulp.task('return:javascript', function() {
    return gulp.src([
        './assets/app/js/main.js',
    ])
        .pipe(gulp.dest('./assets/dev/js/'))
});

// Sprites
gulp.task('svg', function () {
    if(sftp_host) {
        return gulp.src('./assets/dev/svg/*.svg')
            .pipe(svg_min({
                js2svg: {
                    pretty: true
                },
                plugins: [{
                    removeDoctype: true
                }, {
                    removeComments: true
                }, {
                    cleanupNumericValues: {
                        floatPrecision: 2
                    }
                }, {
                    convertColors: {
                        names2hex: false,
                        rgb2hex: false
                    }
                }]
            }))
            .pipe(svg_cheerio({
                run: function ($) {
                    $('[fill]').removeAttr('fill');
                    $('[stroke]').removeAttr('stroke');
                    $('[style]').removeAttr('style');
                },
                parserOptions: {xmlMode: true}
            }))
            .pipe(replace('&gt;', '>'))
            .pipe(svg_sprite({
                mode: {
                    symbol: {
                        sprite: "sprite.svg"
                    }
                }
            }))
            .pipe(gulp.dest('./assets/app/svg/'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathSvg
            }));
    }
    else {
        return gulp.src('./assets/dev/svg/*.svg')
            .pipe(svg_min({
                js2svg: {
                    pretty: true
                },
                plugins: [{
                    removeDoctype: true
                }, {
                    removeComments: true
                }, {
                    cleanupNumericValues: {
                        floatPrecision: 2
                    }
                }, {
                    convertColors: {
                        names2hex: false,
                        rgb2hex: false
                    }
                }]
            }))
            .pipe(svg_cheerio({
                run: function ($) {
                    $('[fill]').removeAttr('fill');
                    $('[stroke]').removeAttr('stroke');
                    $('[style]').removeAttr('style');
                },
                parserOptions: {xmlMode: true}
            }))
            .pipe(replace('&gt;', '>'))
            .pipe(svg_sprite({
                mode: {
                    symbol: {
                        sprite: "sprite.svg"
                    }
                }
            }))
            .pipe(gulp.dest('./assets/app/svg/'))
    }
});

gulp.task('svg-full', function () {
    if(sftp_host) {
        return gulp.src('./assets/dev/svg/full/*.svg')
            .pipe(svg_min({
                js2svg: {
                    pretty: true
                },
                plugins: [{
                    removeDoctype: true
                }, {
                    removeComments: true
                }, {
                    cleanupNumericValues: {
                        floatPrecision: 2
                    }
                }, {
                    convertColors: {
                        names2hex: false,
                        rgb2hex: false
                    }
                }]
            }))
            .pipe(svg_cheerio({
                parserOptions: {xmlMode: true}
            }))
            .pipe(replace('&gt;', '>'))
            .pipe(svg_sprite({
                mode: {
                    symbol: {
                        sprite: "sprite-full.svg"
                    }
                }
            }))
            .pipe(gulp.dest('./assets/app/svg/'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathSvg
            }));
    }
    else {
        return gulp.src('./assets/dev/svg/full/*.svg')
            .pipe(svg_min({
                js2svg: {
                    pretty: true
                },
                plugins: [{
                    removeDoctype: true
                }, {
                    removeComments: true
                }, {
                    cleanupNumericValues: {
                        floatPrecision: 2
                    }
                }, {
                    convertColors: {
                        names2hex: false,
                        rgb2hex: false
                    }
                }]
            }))
            .pipe(svg_cheerio({
                parserOptions: {xmlMode: true}
            }))
            .pipe(replace('&gt;', '>'))
            .pipe(svg_sprite({
                mode: {
                    symbol: {
                        sprite: "sprite-full.svg"
                    }
                }
            }))
            .pipe(gulp.dest('./assets/app/svg/'))
    }
});

// Svg to img
gulp.task('svg:copy', function() {
    if(sftp_host) {
        return gulp.src([
            './assets/dev/img/**/*.svg'
        ])
            .pipe(svg_min({
                js2svg: {
                    pretty: true
                },
                plugins: [{
                    removeDoctype: true
                }, {
                    removeComments: true
                }, {
                    cleanupNumericValues: {
                        floatPrecision: 2
                    }
                }, {
                    convertColors: {
                        names2hex: false,
                        rgb2hex: false
                    }
                }]
            }))
            .pipe(gulp.dest('./assets/app/svg/'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathImg
            }));
    } else {
        return gulp.src([
            './assets/dev/img/**/*.svg'
        ])
            .pipe(svg_min({
                js2svg: {
                    pretty: true
                },
                plugins: [{
                    removeDoctype: true
                }, {
                    removeComments: true
                }, {
                    cleanupNumericValues: {
                        floatPrecision: 2
                    }
                }, {
                    convertColors: {
                        names2hex: false,
                        rgb2hex: false
                    }
                }]
            }))
            .pipe(gulp.dest('./assets/app/svg/'));
    }
});

// Sprite generator
gulp.task('sprite-generator', function() {
    if(sftp_host) {
        var spriteData = gulp.src('./assets/dev/sprite/*.{png,jpg}')
            .pipe(spritesmith({
                imgName: 'sprite_generator.png',
                cssName: 'sprite_generator.css',
                imgPath: '../img/sprite_generator.png',
                padding: 5,

            }))
        spriteData.img.pipe(gulp.dest('./assets/dev/img/'))
        spriteData.css.pipe(gulp.dest('./assets/dev/scss/custom/libs'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathImg
            }));
    } else {
        var spriteData = gulp.src('./assets/dev/sprite/*.{png,jpg}')
            .pipe(spritesmith({
                imgName: 'sprite_generator.png',
                cssName: 'sprite_generator.css',
                imgPath: '../img/sprite_generator.png',
                padding: 5,
            }))
        spriteData.img.pipe(gulp.dest('./assets/dev/img/'))
        spriteData.css.pipe(gulp.dest('./assets/dev/scss/custom/libs'))
    }
});

// Images dev without compression
gulp.task('images:dev', function() {
    if(sftp_host) {
        return gulp.src([
            './assets/dev/img/**/*.{png,jpg,gif}'
        ])
            .pipe(gulp.dest('./assets/app/img/'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathImg
            }));
    } else {
        return gulp.src([
            './assets/dev/img/**/*.{png,jpg,gif}'
        ])
            .pipe(gulp.dest('./assets/app/img/'));
    }
});

// Images build with compression
gulp.task('images:build', function() {
    if(sftp_host) {
        return gulp.src([
            './assets/dev/img/**/*.{png,jpg,gif}'
        ])
            // Add your TINYPNG key for optimize images
            .pipe(tinypng(''))
            .pipe(gulp.dest('./assets/app/img/'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathImg
            }));
    } else {
        return gulp.src([
            './assets/dev/img/**/*.{png,jpg,gif}'
        ])
            // Add your TINYPNG key for optimize images
            .pipe(tinypng(''))
            .pipe(gulp.dest('./assets/app/img/'));
    }
});

// Images webp generations
gulp.task('images:webp', function() {
    if(sftp_host) {
        return gulp.src([
            './assets/dev/img/**/*.{png,jpg,gif}'
        ])
            .pipe(webp())
            .pipe(gulp.dest('./assets/app/img/'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathImg
            }));
    } else {
        return gulp.src([
            './assets/dev/img/**/*.{png,jpg,gif}'
        ])
            .pipe(webp())
            .pipe(gulp.dest('./assets/app/img/'));
    }
});

// Sass to css
gulp.task('sass-to-css', function () {
    if(sftp_host) {
        return gulp.src('./assets/dev/scss/main.scss')
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer({
                cascade: false
            }))
            .pipe(plumber())
            .pipe(cleanCss({
                format: 'beautify'
            }))
            .pipe(concat('main.css'))
            .pipe(gulp.dest('./assets/app/css/'))
            .pipe(csscomb())
            .pipe(csso())
            .pipe(concat('main.min.css'))
            .pipe(gulp.dest('./assets/app/css/'))
            .pipe(sftp({
                host: sftp_host,
                user: sftp_user,
                pass: sftp_pass,
                port: 2222,
                remotePath: pathCss
            }));
    } else {
        return gulp.src('./assets/dev/scss/main.scss')
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer({
                cascade: false
            }))
            .pipe(plumber())
            .pipe(cleanCss({
                format: 'beautify'
            }))
            .pipe(concat('main.css'))
            .pipe(gulp.dest('./assets/app/css/'))
            .pipe(csscomb())
            .pipe(csso())
            .pipe(concat('main.min.css'))
            .pipe(gulp.dest('./assets/app/css/'));
    }
});

// Css to sass
gulp.task('css-to-sass', function () {
    return gulp.src('./assets/app/css/main.css')
        .pipe(rename({
            extname: '.scss'
        }))
        .pipe(gulp.dest('./assets/dev/scss'));
});

// Watch
gulp.task('watch', function() {
    gulp.watch('./assets/dev/js/main.js', gulp.series('javascript'));
    gulp.watch('./assets/dev/scss/main.scss', gulp.series('sass-to-css'));
    gulp.watch('./assets/dev/scss/**/*', gulp.series('sass-to-css'));
    gulp.watch('./assets/dev/img/**/*', gulp.series('images:dev'));
    gulp.watch('./assets/dev/img/**/*', gulp.series('images:webp'));
    gulp.watch('./assets/dev/img/**/*', gulp.series('svg:copy'));
    gulp.watch('./assets/dev/svg/full/*', gulp.series('svg-full'));
    gulp.watch('./assets/dev/svg/*', gulp.series('svg'));
});

// Gulp dev
gulp.task('dev', gulp.parallel('javascript', 'sass-to-css', 'images:dev', 'images:webp', 'svg', 'svg-full', 'svg:copy'));

// Gulp build
gulp.task('build', gulp.parallel('javascript', 'sass-to-css', 'svg', 'svg-full', 'images:build', 'images:webp', 'svg:copy'));

// Gulp return files on website
gulp.task('return-compiled', gulp.parallel('return:javascript', 'css-to-sass'));

// Gulp default
gulp.task('default', gulp.series('dev', gulp.parallel('watch')));