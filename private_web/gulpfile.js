var browserify   = require('browserify');
var cssmin       = require('gulp-cssmin');
var concat       = require('gulp-concat');
var glob         = require('glob');
var gulp         = require('gulp');
var gulpif       = require('gulp-if');
var gutil        = require('gulp-util');
var livereload   = require('gulp-livereload');
var notify       = require('gulp-notify');
var plumber      = require('gulp-plumber');
var reactify     = require('reactify');
var sass         = require('gulp-sass');
var shell        = require('gulp-shell');
var source       = require('vinyl-source-stream');
var streamify    = require('gulp-streamify');
var uglify       = require('gulp-uglify');
var watchify     = require('watchify');
var dependencies = [ 'react', 'react/addons' ];

var jsCompilation = function (options) {
    var appBundler = browserify({
        entries      : [ options.src ],
        transform    : [ reactify ],
        debug        : options.development,
        cache        : {},
        packageCache : {},
        fullPaths    : options.development
    });

    (options.development
        ? dependencies
        : []
    ).forEach(function (dependency) {
        appBundler.external(dependency);
    });

    var rebundle = function (destination_folder) {
        var start = Date.now();
        console.log('Building APP bundle');

        appBundler.bundle()
            .pipe(plumber())
            .pipe(source('main.js'))
            .pipe(gulpif(!options.development, streamify(
                uglify().on('error', gutil.log)
            )))
            .pipe(gulp.dest(destination_folder))
            .pipe(gulpif(options.development, livereload({ start: true })))
            .pipe(notify(function () {
                console.log('APP bundle built in ' + (Date.now() - start) + 'ms');
            }));
    };

    if (options.development) {
        appBundler = watchify(appBundler);
        appBundler.on('update', function () {
            rebundle(options.dest);
        });
    }

    rebundle(options.dest);

    var vendorsBundler  = browserify({ require : dependencies });
    var rebundleVendors = function (destination_folder) {
        console.log('Building VENDORS bundle');
        var start = new Date();

        vendorsBundler.bundle()
            .on('error', gutil.log)
            .pipe(source('vendors.js'))
            .pipe(streamify(uglify()))
            .pipe(gulp.dest(destination_folder))
            .pipe(notify(function () {
                console.log('VENDORS bundle built in ' + (Date.now() - start) + 'ms');
            }));
    };

    rebundleVendors(options.dest);
}


var cssCompilation = function (options) {
    console.log('Building CSS bundle');

    if (options.development) {
        var run = function () {
            var start = new Date();

            gulp.src(options.src)
                .pipe(plumber())
                .pipe(sass())
                .pipe(gulp.dest(options.dest))
                .pipe(notify(function () {
                    console.log('CSS bundle built in ' + (Date.now() - start) + 'ms');
                }));
        };

        run();
        gulp.watch(options.src, run);
    }
    else {
        var start = new Date();

        gulp.src(options.src)
            .pipe(plumber())
            .pipe(sass())
            .pipe(cssmin())
            .pipe(gulp.dest(options.dest))
            .pipe(notify(function () {
            console.log('CSS bundle built in ' + (Date.now() - start) + 'ms');
        }));
    }
}


gulp.task('default', function () {
    jsCompilation({
        development : true,
        src         : './app/main.js',
        dest        : '../web/js',
    });

    cssCompilation({
        development : true,
        src         : './styles/**/*.sass',
        dest        : '../web/css'
    });
});

gulp.task('deploy', function () {
    jsCompilation({
        development : false,
        src         : './app/main.js',
        dest        : '../web/js',
    });

    cssCompilation({
        development : false,
        src         : './styles/**/*.sass',
        dest        : '../web/css'
    });
});