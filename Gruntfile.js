'use strict';
module.exports = function(grunt) {

  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  var jsFileList = [
    // add files, ideally from bower_components, here
    'js/_main.js'
  ];

  grunt.initConfig({

    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'js/*.js',
        '!js/scripts.js',
        '!js/_*.js',
        '!js/*.min.*'
      ]
    },
    less: {
      development: {
        options: {
        },
        files: {
          // target.css file: source.less file
          "style.css": "less/style.less"
        }
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [jsFileList],
        dest: 'js/scripts.js',
      },
    },
    uglify: {
      dist: {
        files: {
          'js/scripts.min.js': [jsFileList]
        }
      }
    },
    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
      },
      no_dest: {
        src: 'style.css'
      }
    },
    modernizr: {
      build: {
        devFile: 'js/vendor/modernizr/modernizr.js',
        outputFile: 'js/modernizr.min.js',
        files: {
          'src': [
            ['js/scripts.min.js'],
            ['style.css']
          ]
        },
        uglify: true,
        parseFiles: true
      }
    },
    makepot: {
      target: {
        options: {
          domainPath: '/languages/',    // Where to save the POT file.
          potFilename: 'bad-feather-nest.pot',   // Name of the POT file.
          type: 'wp-theme',  // Type of project (wp-plugin or wp-theme).
          updateTimestamp: true,
          exclude: [
            'js/.*',
            'less/.*',
            'img/.*',
            'node_modules/.*',
          ]
        }
      }
    },
    watch: {
      less: {
        files: [
          'less/*.less',
        ],
        tasks: ['less']
      },
      js: {
        files: [
          jsFileList,
          '<%= jshint.all %>'
        ],
        tasks: ['jshint', 'concat']
      },
      livereload: {
        // Browser live reloading
        // https://github.com/gruntjs/grunt-contrib-watch#live-reloading
        options: {
          livereload: true
        },
        files: [
          'style.css',
          'js/scripts.js',
          'js/scripts.min.js',
          '*.php'
        ]
      }
    }
  });

  grunt.registerTask( 'default', [
    'less',
    'jshint',
    'concat',
    'autoprefixer'
  ]);

  grunt.registerTask( 'build', [
    'less',
    'jshint',
    'concat',
    'uglify',
    'autoprefixer',
    'makepot',
    'modernizr'
  ]);

};