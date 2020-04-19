var gulp = require('gulp');
var server = require('browser-sync').create();
gulp.task('live', function() {
  server.init({
    proxy: "yeticave", //название папки домена в опен сервере
    notify: false,
    open: true,
    cors: true,
    ui: false
  });

  gulp.watch(["**/*.php","**/*.html","**/*.css","**/*.js"]).on('change', server.reload);
});
