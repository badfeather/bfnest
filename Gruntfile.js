'use strict';
module.exports = function(grunt) {

  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  var jsFileList = [
    // add files, ideally installed via bower (which would put them in assets/vendor)
    'assets/js/scripts.js'
  ];

  grunt.initConfig({

    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'assets/js/*.js'
      ]
    },
    sass: {
      dist: {
        options: {
          style: 'expanded'
        },
        files: {
          'style.css': 'assets/scss/style.scss'
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
        src: ['style.css']
      }
    },
  	imagemin: {
	    theme: {
	      files: [{
  				expand: true,
  				cwd: 'assets/img/',
  				src: ['**/*.{png,jpg,gif,svg}'],
  				dest: 'img/'
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
        options : [
					"setClasses",
					"addTest",
					"html5printshiv",
					"testProp",
					"fnBind"
				],
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
            'assets/.*',
            'img/.*',
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
        src: [ 'assets/scss/style.scss' ],
      }
    },
    watch: {
      sass: {
        files: [
          'assets/scss/*.scss',
          'assets/scss/**/*.scss'
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
          'js/scripts.js',
          'js/scripts.min.js',
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
