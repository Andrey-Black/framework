const { src, dest, parallel, series, watch } = require('gulp');
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
const uglify = require('gulp-uglify-es').default;
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleancss = require('gulp-clean-css');
const imagemin = require('gulp-imagemin');
const newer = require('gulp-newer');
const del = require('del');

function browsersync() {
  browserSync.init({
    server: { baseDir: 'public/' },
    notify: false,
    online: true
  })
}

function scripts() {
  return src(['public/js/script.js'])
  .pipe(concat('script.min.js'))
  .pipe(uglify())
  .pipe(dest('public/js/'))
  .pipe(browserSync.stream())
}

function styles() {
  return src('public/sass/**/*.+(scss|sass)')
  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
  .pipe(concat('style.min.css'))
  .pipe(autoprefixer({ overrideBrowserslist: ['last 10 versions'], grid: true }))
  .pipe(cleancss({ level: { 1: { specialComments: 0 }}}))
  .pipe(dest('public/css/'))
  .pipe(browserSync.stream())
}

function img() {
  return src('public/img/src/**/*')
  .pipe(newer('public/img/dest'))
  .pipe(imagemin())
  .pipe(dest('public/img/dest/'))
}

function cleanimg() {
  return del('public/img/dest/**/*', { force: true});
}

function cleandist() {
  return del('dist/**/*', { force: true});
}

function buildCopy() {
  return src([
    'public/css/**/*.min.css',
    'public/js**/*.min.js',
    'public/img/dest/**/*',
    'public/**/*.html'
  ], { base: 'public' })
  .pipe(dest('dist'))
}

function startWatch() {
  watch('public/sass/**/*.+(scss|sass)', styles);
  watch(['public/**/*.js','!public/**/*.min.js'], scripts);
  watch('public/**/*.html').on('change', browserSync.reload);
  watch('public/img/src/**/*', img);
}

exports.browsersync = browsersync;
exports.scripts     = scripts;
exports.styles      = styles;
exports.img         = img;
exports.cleanimg    = cleanimg;
exports.cleandist   = cleandist;
exports.build       = series(cleandist, styles, scripts, img, buildCopy);
exports.default     = parallel(styles, scripts, browsersync, startWatch);
