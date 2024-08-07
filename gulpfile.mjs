import { src, dest, parallel, series, watch } from 'gulp';
import browserSync from 'browser-sync';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify-es';
import gulpSass from 'gulp-sass';  // Переименуйте import для gulp-sass
import sassCompiler from 'sass';    // Импортируйте компилятор Sass
import autoprefixer from 'gulp-autoprefixer';
import cleancss from 'gulp-clean-css';
import imagemin from 'gulp-imagemin';
import newer from 'gulp-newer';
import { deleteAsync as del } from 'del';

// Установка компилятора для gulp-sass
const sass = gulpSass(sassCompiler);

const browserSyncInstance = browserSync.create();

function browsersync() {
  browserSyncInstance.init({
    server: { baseDir: 'public/' },
    notify: false,
    online: true
  });
}

function scripts() {
  return src(['public/js/script.js'])
    .pipe(concat('script.min.js'))
    .pipe(uglify.default())
    .pipe(dest('public/js/'))
    .pipe(browserSyncInstance.stream());
}

function styles() {
  return src('public/sass/**/*.+(scss|sass)')
    .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
    .pipe(concat('style.min.css'))
    .pipe(autoprefixer({ overrideBrowserslist: ['last 10 versions'], grid: true }))
    .pipe(cleancss({ level: { 1: { specialComments: 0 } } }))
    .pipe(dest('public/css/'))
    .pipe(browserSyncInstance.stream());
}

function img() {
  return src('public/img/src/**/*')
    .pipe(newer('public/img/dest'))
    .pipe(imagemin())
    .pipe(dest('public/img/dest/'));
}

function cleanimg() {
  return del('public/img/dest/**/*', { force: true });
}

function cleandist() {
  return del('dist/**/*', { force: true });
}

function buildCopy() {
  return src([
    'public/css/**/*.min.css',
    'public/js/**/*.min.js',
    'public/img/dest/**/*',
    'public/**/*.php'
  ], { base: 'public' })
    .pipe(dest('dist'));
}

function startWatch() {
  watch('public/sass/**/*.+(scss|sass)', styles);
  watch(['public/**/*.js', '!public/**/*.min.js'], scripts);
  watch('public/**/*.php').on('change', browserSyncInstance.reload);
  watch('public/img/src/**/*', img);
}

export { browsersync, scripts, styles, img, cleanimg, cleandist, buildCopy };
export default parallel(styles, scripts, browsersync, startWatch);
