module.exports = function ( grunt ) {
	// Load all grunt tasks in package.json matching the `grunt-*` pattern.
	require( 'load-grunt-tasks' )( grunt );

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		/**
		 * Minify SVGs using SVGO.
		 *
		 * @link https://github.com/sindresorhus/grunt-svgmin
		 */
		svgmin: {
			options: {
				plugins: [
					{removeComments: true},
					{removeUselessStrokeAndFill: true},
					{removeEmptyAttrs: true}
				]
			},
			dist: {
				files: [ {
					expand: true,
					cwd: 'assets/img/svg-icons/',
					src: [ '*.svg' ],
					dest: 'assets/img/svg-icons/'
				} ]
			}
		},

		/**
		 * Merge SVGs into a single SVG.
		 *
		 * @link https://github.com/FWeinb/grunt-svgstore
		 */
		svgstore: {
			options: {
				prefix: 'icon-',
				cleanup: [ 'fill', 'style' ],
				svg: {
					style: 'display: none;'
				}
			},
			dist: {
				files: {
					'assets/img/svg-defs.svg': 'assets/img/svg-icons/*.svg'
				}
			}
		},

		/**
		 * Compile Sass into CSS using node-sass.
		 *
		 * @link https://github.com/sindresorhus/grunt-sass
		 */
		sass: {
			options: {
				outputStyle: 'expanded',
				sourceComments: false,
				sourceMap: true,
				includePaths: [
				]
			},
			dist: {
				files: {
					'style.css': 'assets/sass/style.scss',
				}
			}
		},

		/**
		 * Apply several post-processors to CSS using PostCSS.
		 *
		 * @link https://github.com/nDmitry/grunt-postcss
		 */
		postcss: {
			options: {
				map: true,
				processors: [
					require( 'autoprefixer' )( {'browsers': 'last 2 versions'} ),
					require( 'css-mqpacker' )( {'sort': true} )
				]},
			dist: {
				src: [ 'style.css' ]
			}
		},

		/**
		 * A modular minifier, built on top of the PostCSS ecosystem.
		 *
		 * @link https://github.com/ben-eb/cssnano
		 */
		cssnano: {
			options: {
				autoprefixer: false,
				safe: true
			},
			dist: {
				files: {
					'style.min.css': 'style.css',
				}
			}
		},

		/**
		 * Bump version numbers
		 * @link https://github.com/kswedberg/grunt-version
		 */
		version: {
			css: {
				options: {
					prefix: 'Version\\:\\s'
				},
				src: [ 'assets/sass/style.scss', 'style.css', 'style.min.css', 'README.md' ]
			},
			json: {
				src: ['*.json']
			},
		},

		/**
		 * Concatenate files.
		 *
		 * @link https://github.com/gruntjs/grunt-contrib-concat
		 */
		concat: {
			dist: {
				src: [
					'assets/js/concat/js-enabled.js',
					'assets/js/concat/theme.js',
				 ],
				dest: 'assets/js/build/theme.js'
			},
		},

		/**
		 * Minify files with UglifyJS.
		 *
		 * @link https://github.com/gruntjs/grunt-contrib-uglify
		 */
		uglify: {
			concat: {
				options: {
					//sourceMap: true,
					mangle: false
				},
				files: [ {
					expand: true,
					cwd: 'assets/js/build/',
					src: [ '**/*.js', '!**/*.min.js' ],
					dest: 'assets/js/build/',
					ext: '.min.js'
				} ]
			}
		},

		/**
		 * Minify PNG, JPG, and GIF images.
		 *
		 * @link https://github.com/gruntjs/grunt-contrib-imagemin
		 */
		imagemin: {
			dynamic: {
				files: [ {
					expand: true,
					cwd: 'assets/img/',
					src: [ '**/*.{png,jpg,gif}' ],
					dest: 'assets/img/'
				} ]
			}
		},

		/**
		 * Run tasks whenever watched files change.
		 *
		 * @link https://github.com/gruntjs/grunt-contrib-watch
		 */
		watch: {
			scripts: {
				files: [ 'assets/js/**/*.js' ],
				tasks: [ 'javascript' ],
			},

			css: {
				files: [ 'assets/sass/**/*.scss' ],
				tasks: [ 'styles' ],
			},

			svg: {
				files: [ 'assets/img/svg-icons/*.svg' ],
				tasks: [ 'svgstore' ],
			},

			images: {
				files: [ 'assets/img/*' ],
				tasks: [ 'imagemin' ],
			}
		},

		/**
		 * Internationalize WordPress themes and plugins.
		 *
		 * @link https://github.com/claudiosmweb/grunt-wp-i18n
		 */
		makepot: {
			target: {
				options: {
					domainPath: 'languages/',		 // Where to save the POT file.
					potFilename: 'sstk-blog.pot',		// Name of the POT file.
					type: 'wp-theme',	 // Type of project (wp-plugin or wp-theme).
					updateTimestamp: true,
					exclude: [
						'assets/.*',
						'node_modules/.*',
						'docs/.*'
					]
				}
			}
		},

	} );

	// Register Grunt tasks.
	grunt.registerTask( 'styles', [ 'sass', 'postcss', 'cssnano' ] );
	grunt.registerTask( 'javascript', [ 'concat', 'uglify' ] );
	grunt.registerTask( 'images', [ 'imagemin' ] );
	grunt.registerTask( 'svg', [ 'svgmin', 'svgstore' ] );
	grunt.registerTask( 'i18n', [ 'makepot' ] );
	grunt.registerTask( 'bump-patch', [ 'version::patch' ] );
	grunt.registerTask( 'bump-minor', [ 'version::minor' ] );
	grunt.registerTask( 'bump-major', [ 'version::major' ] );
	grunt.registerTask( 'default', [
		'styles',
		'javascript',
		'images',
		'svg',
		'i18n'
	] );
};
