var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

var sassPaths = [

];

var config = {
    jsPath: './resources/javascript',
    adminJsPath: './resources/javascript/admin',

     sassPath: './resources/scss',
     nodePath: './node_modules' 
}

var DO_WATCH = ($.util.env.watch ? true : false);

var sources = {
  admin: {
    scripts: [
        config.nodePath + '/jquery/dist/jquery.min.js',
        config.nodePath + '/bootstrap-validator/dist/validator.js',
        config.nodePath + '/select2/dist/js/select2.js',
        config.nodePath + '/bootstrap-maxlength/src/bootstrap-maxlength.js',             
        config.nodePath + '/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        config.nodePath + '/bootstrap-datepicker/js/bootstrap-datepicker.js',
        config.nodePath + '/datatables/media/js/jquery.dataTables.js',
        config.nodePath + '/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',        
        config.nodePath + '/jstree/dist/jstree.min.js',
        config.nodePath + '/summernote/dist/summernote.min.js',   
        config.nodePath + '/iCheck/icheck.min.js',
        config.adminJsPath   + '/main.js',
        config.nodePath + '/codemirror/lib/codemirror.js',
        config.nodePath + '/sweetalert/dist/sweetalert.min.js',
        config.nodePath + '/wchar/wchar.min.js',

    ],
    resources: [
      'resources/assets/**/*'
    ],
    fonts: [
        config.nodePath + '/foundation-icon-fonts/**/**.*', 
        config.nodePath + '/font-awesome/fonts/**/**.*', 
        config.nodePath + '/roboto-fontface/fonts/**/**.*', 
        config.nodePath + '/bootstrap-sass-official/assets/fonts/bootstrap/**/**.*'
    ]
  },
  site: {
    scripts: [
        config.nodePath + '/jquery/dist/jquery.min.js',           
        config.nodePath + '/bootstrap-sass-official/assets/javascripts/bootstrap.min.js',
        config.nodePath + '/bootstrap-datepicker/js/bootstrap-datepicker.js',
        config.nodePath + '/datatables/media/js/jquery.dataTables.js',
        config.nodePath + '/datatables-select/js/dataTables.select.js',
        config.nodePath + '/datatables-buttons/js/buttons.bootstrap.select.js',
        config.nodePath + '/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',        
        config.nodePath + '/jstree/dist/jstree.min.js',
        config.nodePath + '/summernote/dist/summernote.min.js',   
        config.nodePath + '/iCheck/icheck.min.js',
        config.jsPath   + '/main.js',
        config.nodePath + '/codemirror/lib/codemirror.js',
        config.nodePath + '/sweetalert/dist/sweetalert.min.js',
        config.nodePath + '/wchar/wchar.min.js',

    ],
    resources: [
      'resources/assets/**/*'
    ],
    fonts: [
        config.nodePath + '/foundation-icon-fonts/**/**.*', 
        config.nodePath + '/font-awesome/fonts/**/**.*', 
        config.nodePath + '/roboto-fontface/fonts/**/**.*', 
        config.nodePath + '/bootstrap-sass-official/assets/fonts/bootstrap/**/**.*'
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


gulp.task('frontendjavascript', function() { 
    return gulp.src(sources.site.scripts) 
        .pipe($.plumber())
        .pipe($.concat('site.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./public/javascript/'))

});




gulp.task('jstree', function() { 
    return gulp.src(config.nodePath + '/jstree/src/themes/default/**.*') 
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




gulp.task('default', [ 'jstree', 'icons', 'frontendcss', 'backendcss', 'adminjavascript', 'frontendjavascript'], function() {
if (DO_WATCH) {
    gulp.watch(['./resources/scss/**/*.scss'], ['backendcss']);
    gulp.watch(['./resources/scss/**/*.scss'], ['frontendcss']);
    gulp.watch([config.jsPath + '/main.js'], ['frontendjavascript']);
    gulp.watch([config.jsPath + '/admin/main.js'], ['adminjavascript']);

}

});