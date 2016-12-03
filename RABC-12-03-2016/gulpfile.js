var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var minifyCSS = require('gulp-minify-css');
var concatCss = require('gulp-concat-css');
var fontmin = require('gulp-fontmin');
var imagemin = require('gulp-imagemin');
var nodemon = require('gulp-nodemon');

var paths = {
	scripts:[' public/js/jquery.min.js', 
			  'public/js/bootstrap.min.js', 
			  'public/js/bootstrap-hover-dropdown.js',
			  'public/js/select2.min.js',
			  'public/js/angular.min.js',
			  'public/controllers/app.js',
			  'public/controllers/*.controller.js'
			],
	styles:['public/css/*.css'
			],
	fonts: ['public/fonts/*.ttf',
			'public/fonts/*.woff',
			'public/fonts/*.woff2'
			],
	images:['public/image/*.jpg',
			'public/image/*.png',
			'public/image/*.jpeg'
			]
};

gulp.task('scripts',function(){
	gulp.src(paths.scripts)
		.pipe(concat('all.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('../dist/js'))
});

gulp.task('css',function(){
	return gulp.src(paths.styles)
		.pipe(concatCss("style.css"))
		.pipe(minifyCSS({
			keepBreaks: true
		}))
		.pipe(gulp.dest('../dist/css/'))
});

gulp.task('fonts', function () {
    return gulp.src(paths.fonts)
        .pipe(fontmin())
        .pipe(gulp.dest('../dist/fonts'));
});

gulp.task('image', function () {
    gulp.src(paths.images)
        .pipe(imagemin())
        .pipe(gulp.dest('../dist/image'))
});


gulp.task('server', function() {
    nodemon({
        script: 'server.js',
        watch: ["server.js","routes/*.js","config/*.js"],
        ext: 'js'
    }).on('restart', () => {
    gulp.src('server.js');
  });
});

gulp.task('watch', function() {
  gulp.watch(paths.scripts, ['scripts']);
  gulp.watch(paths.styles, ['css']);
  gulp.watch(paths.fonts, ['fonts']);
  gulp.watch(paths.image, ['image']);
  gulp.watch(["server.js"], ['server']);
});

gulp.task('default', ['watch', 'scripts','css','fonts','image','server']);