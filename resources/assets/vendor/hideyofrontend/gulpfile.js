var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

var sassPaths = [
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

var config = {
    jsPath: 'javascript',
     sassPath: 'scss',
     bowerDir: 'bower_components' 
}

var DO_WATCH = ($.util.env.watch ? true : false);

var sources = {
  frontend: {
    scripts: [
        config.bowerDir + '/jquery/dist/jquery.min.js',
        config.bowerDir + '/bootstrap-validator/dist/validator.js',
        config.bowerDir + '/select2/dist/js/select2.js',
        config.bowerDir + '/bootstrap-maxlength/src/bootstrap-maxlength.js',             
        config.bowerDir + '/bootstrap-sass-official/assets/javascripts/bootstrap.min.js',
        config.bowerDir + '/bootstrap-datepicker/js/bootstrap-datepicker.js',
        config.bowerDir + '/datatables/media/js/jquery.dataTables.js',
        config.bowerDir + '/datatables-select/js/dataTables.select.js',
        config.bowerDir + '/datatables-buttons/js/buttons.bootstrap.select.js',
        config.bowerDir + '/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
        config.jsPath   + '/main.js'
    ],
    resources: [
      'resources/assets/**/*'
    ],
    fonts: [
        config.bowerDir + '/font-awesome/fonts/**/**.*', 
        config.bowerDir + '/bootstrap-sass-official/assets/fonts/bootstrap/**/**.*',
        config.bowerDir + '/jstree/src/themes/default/**.*',
        config.bowerDir + '/open-sans/fonts/**/**.*'
    ]
  }

};



gulp.task('javascript', function() { 
    return gulp.src(sources.frontend.scripts) 
        .pipe($.plumber())
        .pipe($.concat('frontend.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('../../../../public/hideyo/javascript/'))

});

gulp.task('bower', function() { 
    return $.bower()
         .pipe(gulp.dest(config.bowerDir)) 
});

gulp.task('sass', function() {
    return gulp.src('./scss/style.scss')
        .pipe($.sass({
          includePaths: [sassPaths]
        })
          .on('error', $.sass.logError))
        .pipe($.autoprefixer({
          browsers: ['last 2 versions', 'ie >= 9']
        }))
        //.pipe($.cleanCss())
        .pipe($.concat('frontend.css'))
        .pipe(gulp.dest('../../../../public/hideyo/css/'));
});


gulp.task('default', ['bower', 'sass',  'javascript'], function() {
if (DO_WATCH) {
    gulp.watch(['./resources/scss/**/*.scss'], ['adminsass']);
    gulp.watch([config.jsPath + '/admin/main.js'], ['adminjavascript']);

}

});