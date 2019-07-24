var theme = 'begonia-lite';

var gulp = require('gulp'),
  plugins = require('gulp-load-plugins')();

// Gulp / Node utilities
var u = require('gulp-util');
var log = u.log;
var c = u.colors;
var del = require('del');
var fs = require('fs');
var cp = require('child_process');

// Basic workflow plugins
var bs = require('browser-sync');
var reload = bs.reload;

var jsFiles = [
    './assets/js/modules/*.js',
    './assets/js/main/main.js',
    './assets/js/main/unsorted.js',
    './assets/js/vendor/*.js'
];

var config = require('./gulpconfig.json');

// -----------------------------------------------------------------------------
// Sass Tasks
//
// Compiles Sass and runs the CSS through autoprefixer. A separate task will
// combine the compiled CSS with vendor files and minify the aggregate.
// -----------------------------------------------------------------------------
gulp.task('style.css', function() {
    return gulp.src('assets/scss/*.scss')
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass({outputStyle: 'nested'}).on('error', plugins.sass.logError))
        .pipe(plugins.autoprefixer())
        .pipe(plugins.sourcemaps.write('.'))
        .pipe(gulp.dest('.'));
});

gulp.task('rtl.css', function() {
    return gulp.src('style.css')
        .pipe(plugins.rtlcss())
        .pipe(plugins.rename('rtl.css'))
        .pipe(gulp.dest('.'));
});

function stylesSequence(cb) {
  gulp.series('style.css', 'rtl.css')(cb);
}
stylesSequence.description = 'Compile all styles';
gulp.task('styles', stylesSequence )

// -----------------------------------------------------------------------------
// Combine JavaScript files
// -----------------------------------------------------------------------------
gulp.task('scripts', function () {
    return gulp.src(['./assets/js/**/*.js', '!./assets/js/main.js'])
    // Concatenate all our files into main.js
        .pipe(plugins.concat('main.js'))
        // Wrap all js logic in an immediately invoked function expression (iife)
        .pipe(plugins.iife({
            params: ["window", "document", "$"],
            args: ["window", "document", "jQuery"]
        }))
        .pipe(gulp.dest('./assets/js/'));
});

// -----------------------------------------------------------------------------
// Browser Sync using Proxy server
//
// Makes web development better by eliminating the need to refresh. Essential
// for CSS development and multi-device testing.
//
// This is how you'd connect to a local server that runs itself.
// Examples would be a PHP site such as Wordpress or a
// Drupal site, or a node.js site like Express.
//
// Usage: gulp browser-sync-proxy --port 8080
// -----------------------------------------------------------------------------
gulp.task('browser-sync', function () {
    bs({
        // Point this to your pre-existing server.
        proxy: config.baseurl + (u.env.port ? ':' + u.env.port : ''),
        files: ['*.php', 'style.css', 'assets/js/main.js'],
        // This tells BrowserSync to auto-open a tab once it boots.
        open: true
    }, function(err, bs) {
        if (err) {
            console.log(bs.options);
        }
    });
});


// -----------------------------------------------------------------------------
// Watch tasks
//
// These tasks are run whenever a file is saved. Don't confuse the files being
// watched (gulp.watch blobs in this task) with the files actually operated on
// by the gulp.src blobs in each individual task.
//
// A few of the performance-related tasks are excluded because they can take a
// bit of time to run and don't need to happen on every file change. If you want
// to run those tasks more frequently, set up a new watch task here.
// -----------------------------------------------------------------------------
gulp.task('watch', function() {
    gulp.watch('assets/scss/**/*.scss', ['styles']);
    gulp.watch('assets/js/**/*.js', ['scripts']);
});

// -----------------------------------------------------------------------------
// Copy theme folder outside in a build folder, recreate styles before that
// -----------------------------------------------------------------------------
function copyFolder() {

  var dir = process.cwd();
  return gulp.src( './*' )
    .pipe( plugins.exec( 'rm -Rf ./../build; mkdir -p ./../build/' + theme + ';', {
      silent: true,
      continueOnError: true // default: false
    } ) )
    .pipe(plugins.rsync({
      root: dir,
      destination: '../build/' + theme + '/',
      // archive: true,
      progress: false,
      silent: true,
      compress: false,
      recursive: true,
      emptyDirectories: true,
      clean: true,
      exclude: ['node_modules']
    }));
}
copyFolder.description = 'Copy theme production files to a build folder';
gulp.task( 'copy-folder', copyFolder );

function maybeFixBuildDirPermissions(done) {

  cp.execSync('find ./../build -type d -exec chmod 755 {} \\;');

  return done();
}
maybeFixBuildDirPermissions.description = 'Make sure that all directories in the build directory have 755 permissions.';
gulp.task( 'fix-build-dir-permissions', maybeFixBuildDirPermissions );

function maybeFixBuildFilePermissions(done) {

  cp.execSync('find ./../build -type f -exec chmod 644 {} \\;');

  return done();
}
maybeFixBuildFilePermissions.description = 'Make sure that all files in the build directory have 644 permissions.';
gulp.task( 'fix-build-file-permissions', maybeFixBuildFilePermissions );

function maybeFixIncorrectLineEndings(done) {

  cp.execSync('find ./../build -type f -print0 | xargs -0 -n 1 -P 4 dos2unix');

  return done();
}
maybeFixIncorrectLineEndings.description = 'Make sure that all line endings in the files in the build directory are UNIX line endings.';
gulp.task( 'fix-line-endings', maybeFixIncorrectLineEndings );

// -----------------------------------------------------------------------------
// Replace the themes' text domain with the actual text domain (think variations)
// -----------------------------------------------------------------------------
function themeTextdomainReplace() {
  return gulp.src( '../build/' + theme + '/**/*.php' )
    .pipe( plugins.replace( /['|"]__theme_txtd['|"]/g, '\'' + theme + '\'' ) )
    .pipe( gulp.dest( '../build/' + theme ) );
}
gulp.task( 'txtdomain-replace', themeTextdomainReplace );

// -----------------------------------------------------------------------------
// Remove unneeded files and folders from the build folder
// -----------------------------------------------------------------------------
gulp.task('remove-unneeded-files', function () {

    // files that should not be present in build
    files_to_remove = [
        '**/codekit-config.json',
        'node_modules',
        'config.rb',
        'gulpfile.js',
        'gulpconfig.js',
        'gulpconfig.json',
        'package.json',
        'pxg.json',
        'build',
        'css',
        '.idea',
        '**/.svn*',
        '**/*.css.map',
        '**/.sass*',
        '.sass*',
        '**/.git*',
        '*.sublime-project',
        '.DS_Store',
        '**/.DS_Store',
        '__MACOSX',
        '**/__MACOSX',
        'README.md',
        '.csscomb',
        '.codeclimate.yml',
        'browserslist',
    ];

    files_to_remove.forEach(function (e, k) {
        files_to_remove[k] = '../build/' + theme + '/' + e;
    });

    return del(files_to_remove, {force: true});
});

function buildSequence(cb) {
  return gulp.series( 'copy-folder', 'remove-unneeded-files', 'fix-build-dir-permissions', 'fix-build-file-permissions', 'fix-line-endings', 'txtdomain-replace' )(cb);
}
buildSequence.description = 'Sets up the build folder';
gulp.task( 'build', buildSequence );

// -----------------------------------------------------------------------------
// Create the theme installer archive and delete the build folder
// -----------------------------------------------------------------------------
function makeZip() {

    var versionString = '';
    // get theme version from styles.css
    var contents = fs.readFileSync("./style.css", "utf8");

    // split it by lines
    var lines = contents.split(/[\r\n]/);

    function checkIfVersionLine(value, index, ar) {
        var myRegEx = /^[Vv]ersion:/;
        if ( myRegEx.test(value) ) {
            return true;
        }
        return false;
    }

    // apply the filter
    var versionLine = lines.filter(checkIfVersionLine);

    versionString = versionLine[0].replace(/^[Vv]ersion:/, '' ).trim();
    versionString = '-' + versionString.replace(/\./g,'-');

    return gulp.src('./')
        .pipe(plugins.exec('cd ./../; rm -rf ' + theme + '*.zip; cd ./build/; zip -r -X ./../' + theme +'.zip ./; cd ./../; rm -rf build'));
}
makeZip.description = 'Create the theme installer archive and delete the build folder';
gulp.task( 'make-zip', makeZip );

function zipSequence(cb) {
  return gulp.series( 'build', 'make-zip' )(cb);
}
zipSequence.description = 'Creates the zip file';
gulp.task( 'zip', zipSequence  );
