'use strict';
module.exports = function(grunt) {

  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  var jsFileList = [
    'assets/js/concat/*.js',
    // add files, ideally installed via bower (which would put them in assets/vendor)
  ];

  grunt.initConfig({

    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'assets/js/concat/*.js'
      ]
    },
    sass: {
      dist: {
        options: {
          style: 'expanded'
        },
        files: {
          'style.css': 'assets/sass/style.scss'
        }
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [jsFileList],
        dest: 'assets/js/project.js',
      },
    },
    uglify: {
      dist: {
        files: {
          'assets/js/project.min.js': [jsFileList]
        }
      }
    },
    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
      },
      no_dest: {
        src: ['style.css']
      }
    },
  	imagemin: {
	    theme: {
	      files: [{
  				expand: true,
  				cwd: 'assets/img/',
  				src: ['**/*.{png,jpg,gif,svg}'],
  				dest: 'assets/img/'
			  }]
	    }
  	},
    modernizr: {
      build: {
        devFile: 'node_modules/grunt-modernizr/lib/build-files/modernizr-latest.js',
        outputFile: 'js/modernizr.min.js',
        files: {
          'src': ['js/ss.min.js', 'style.css']
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
            'assets/.*',
            'node_modules/.*',
            'docs/.*'
          ]
        }
      }
    },
    version: {
      json: {
        src: ['package.json', 'bower.json']
      },
      scss: {
        options: {
          prefix: 'Version\\:\\s'

        },
        src: [ 'assets/sass/style.scss' ],
      }
    },
    watch: {
      sass: {
        files: [
          'assets/sass/*.scss',
          'assets/sass/**/*.scss'
        ],
        tasks: ['sass']
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
          'assets/js/project.js',
          'assets/js/project.min.js',
          '*.php'
        ]
      }
    }
  });

  grunt.registerTask( 'default', [
    'sass',
    'jshint',
    'concat',
    'autoprefixer'
  ]);

  grunt.registerTask( 'build', [
    'sass',
    'jshint',
    'concat',
    'uglify',
    'autoprefixer',
    'imagemin',
    'modernizr',
    'makepot',
  ]);

};
