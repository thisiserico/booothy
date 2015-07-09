var gulp             = require('gulp');
var source           = require('vinyl-source-stream');
var browserify       = require('browserify');
var watchify         = require('watchify');
var reactify         = require('reactify');
var gulpif           = require('gulp-if');
var uglify           = require('gulp-uglify');
var streamify        = require('gulp-streamify');
var notify           = require('gulp-notify');
var concat           = require('gulp-concat');
var cssmin           = require('gulp-cssmin');
var gutil            = require('gulp-util');
var sass             = require('gulp-sass');
var shell            = require('gulp-shell');
var glob             = require('glob');
var livereload       = require('gulp-livereload');
var jasminePhantomJs = require('gulp-jasmine2-phantomjs');
var dependencies     = [ 'react', 'react/addons' ];

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
            .on('error', gutil.log)
            .pipe(source('main.js'))
            .pipe(gulpif(!options.development, streamify(uglify())))
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
            rebundle(options.build_dest);
        });
    }

    rebundle(options.dest);
    rebundle(options.build_dest);


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
    rebundleVendors(options.build_dest);


    if (options.development) {
        var testFiles   = glob.sync('./specs/**/*-spec.js');
        var testBundler = browserify({
            entries      : testFiles,
            debug        : true,
            transform    : [ reactify ],
            cache        : {},
            packageCache : {},
            fullPaths    : true
        });

        dependencies.forEach(function (dependency) {
            testBundler.external(dependency);
        });

        var rebundleTests = function (destination_folder) {
            var start = Date.now();
            console.log('Building TEST bundle');

            testBundler.bundle()
                .on('error', gutil.log)
                .pipe(source('specs.js'))
                .pipe(gulp.dest(destination_folder))
                .pipe(livereload({ start: true }))
                .pipe(notify(function () {
                    console.log('TEST bundle built in ' + (Date.now() - start) + 'ms');
                }));
        };

        testBundler = watchify(testBundler);
        testBundler.on('update', function () {
            rebundleTests(options.build_dest);
        });

        rebundleTests(options.build_dest);
    }
}

var cssCompilation = function (options) {
    var start = new Date();

    if (options.development) {
        var run = function () {
            console.log('Building CSS bundle');

            gulp.src(options.src)
                .pipe(sass({
                    errLogToConsole: true
                }))
                .pipe(gulp.dest(options.dest))
                .pipe(notify(function () {
                    console.log('CSS bundle built in ' + (Date.now() - start) + 'ms');
                }));
        };

        run();
        gulp.watch(options.src, run);
    }
    else {
      gulp.src(options.src)
        .pipe(sass({
            errLogToConsole: true
        }))
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
        build_dest  : './build'
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
        build_dest  : './build'
    });

    cssCompilation({
        development : false,
        src         : './styles/**/*.sass',
        dest        : '../web/css'
    });
});

gulp.task('test', function () {
    return gulp.src('./build/testrunner-phantomjs.html').pipe(jasminePhantomJs());
});