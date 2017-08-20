var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

var sassPaths = [

];

var config = {
    jsPath: './resources/javascript',
     sassPath: './resources/scss',
     bowerDir: './bower_components' 
}

var DO_WATCH = ($.util.env.watch ? true : false);

var sources = {
  admin: {
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
        config.bowerDir + '/jstree/dist/jstree.min.js',
        config.bowerDir + '/summernote/dist/summernote.min.js',   
        config.bowerDir + '/iCheck/icheck.min.js',
        config.jsPath   + '/main.js',
        config.bowerDir + '/codemirror/lib/codemirror.js',
        config.bowerDir + '/sweetalert/dist/sweetalert.min.js',
        config.bowerDir + '/wchar/wchar.min.js',

    ],
    resources: [
      'resources/assets/**/*'
    ],
    fonts: [
        config.bowerDir + '/foundation-icon-fonts/**/**.*', 
        config.bowerDir + '/font-awesome/fonts/**/**.*', 
        config.bowerDir + '/roboto-fontface/fonts/**/**.*', 
        config.bowerDir + '/bootstrap-sass-official/assets/fonts/bootstrap/**/**.*'
    ]
  }

};


gulp.task('icons', function() { 
    return gulp.src(sources.admin.fonts) 
        .pipe(gulp.dest('public/fonts')); 
});


gulp.task('adminjavascript', function() { 
    return gulp.src(sources.admin.scripts) 
        .pipe($.plumber())
        .pipe($.concat('site.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./public/javascript/admin/'))

});

gulp.task('bower', function() { 
    return $.bower()
         .pipe(gulp.dest(config.bowerDir)) 
});

gulp.task('jstree', function() { 
    return gulp.src(config.bowerDir + '/jstree/src/themes/default/**.*') 
        .pipe(gulp.dest('public/javascript/jstree')); 
});



gulp.task('backendcss', function() {
    return gulp.src('./resources/scss/backend/style.scss')
        .pipe($.sass({
          includePaths: sassPaths
        })
          .on('error', $.sass.logError))
        .pipe($.autoprefixer({
          browsers: ['last 2 versions', 'ie >= 9']
        }))
        .pipe($.minifyCss())
        .pipe(gulp.dest('./public/css/admin/'));
});


gulp.task('frontendcss', function() {
    return gulp.src('./resources/scss/frontend/style.scss')
        .pipe($.sass({
          includePaths: sassPaths
        })
          .on('error', $.sass.logError))
        .pipe($.autoprefixer({
          browsers: ['last 2 versions', 'ie >= 9']
        }))
        .pipe($.minifyCss())
        .pipe(gulp.dest('./public/css/'));
});




gulp.task('default', ['bower', 'jstree', 'icons', 'frontendcss', 'backendcss', 'adminjavascript'], function() {
if (DO_WATCH) {
    gulp.watch(['./resources/scss/**/*.scss'], ['backendcss']);
    gulp.watch(['./resources/scss/**/*.scss'], ['frontendcss']);
    gulp.watch([config.jsPath + '/admin/main.js'], ['adminjavascript']);

}

});