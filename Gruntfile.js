module.exports = function ( grunt ) {

	const sass = require('node-sass');

	// Load all grunt tasks in package.json matching the `grunt-*` pattern.
	require( 'load-grunt-tasks' )( grunt );

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		/**
		 * Compile Sass into CSS using node-sass.
		 *
		 * @link https://github.com/sindresorhus/grunt-sass
		 */
		sass: {
			options: {
				implementation: sass,
				sourceMap: true,
				outputStyle: 'expanded',
			},
			dist: {
				files: {
					'assets/dist/css/theme.css': 'assets/src/sass/theme.scss',
					'assets/dist/css/editor-style.css': 'assets/src/sass/editor-style.scss',
					'assets/dist/css/woocommerce.css': 'assets/src/sass/woocommerce.scss'
				}
			}
		},

		/**
		 * Apply several post-processors to CSS using PostCSS.
		 *
		 * @link https://github.com/nDmitry/grunt-postcss
		 */
		postcss: {
			css: {
				options: {
					map: true,
					processors: [
						require( 'autoprefixer' ),
						require('pixrem')(),
						require( 'postcss-combine-media-query' )(),
					]
				},
				src: [
					'assets/dist/css/*.css',
					'!assets/dist/css/*.min.css',
				]
			},
			min: {
				options: {
					map: false,
					processors: [
						require('cssnano')()
					]
				},
				files: [ {
					expand: true,
					cwd: 'assets/dist/css/',
					src: [ '**/*.css', '!**/*.min.css' ],
					dest: 'assets/dist/css/',
					ext: '.min.css'
				} ],
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
				src: [ 'style.css', 'README.md' ]
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
					'assets/src/js/js-enabled.js',
					'assets/src/js/navigation.js',
					'assets/src/js/share-popup.js',
					'assets/src/js/skip-link-focus-fix.js',
					'assets/src/js/theme.js',
				],
				dest: 'assets/dist/js/theme.js'
			},
			blocks: {
				src: [
					'assets/src/js/block-filters.js',
				],
				dest: 'assets/dist/js/block-filters.js'
			}
		},

		/**
		 * Lint js files using WordPress eslint coding standards
		 * https://www.npmjs.com/package/grunt-eslint
		 * https://github.com/WordPress-Coding-Standards/eslint-plugin-wordpress
		 */
		eslint: {
			src: [ 'assets/src/js/*.js' ],
		},

		/**
		 * Minify files with UglifyJS.
		 *
		 * @link https://github.com/gruntjs/grunt-contrib-uglify
		 */
		uglify: {
			dist: {
				options: {
					//sourceMap: true,
					mangle: false
				},
				files: [ {
					expand: true,
					cwd: 'assets/dist/js/',
					src: [ '**/*.js', '!**/*.min.js' ],
					dest: 'assets/dist/js/',
					ext: '.min.js'
				} ]
			}
		},

		/**
		 * Minify SVG files using SVGO
		 * @link https://github.com/sindresorhus/grunt-svgmin
		 */
		svgmin: {
			options: {
				plugins: [
					{
						removeViewBox: false
					},
				]
			},
			dist: {
				files: [{
					expand: true,
					cwd: 'assets/src/img/',
					src: ['**/*.svg'],
					dest: 'assets/dist/img/',
				}]
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
					'assets/dist/img/svg-sprite.svg': 'assets/dist/img/svg-sprite/**/*.svg'
				}
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
					cwd: 'assets/src/img/',
					src: [ '**/*.{png,jpg,gif}' ],
					dest: 'assets/dist/img/'
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
				files: [ 'assets/src/js/*.js' ],
				tasks: [ 'javascript' ],
				options: {
					spawn: false,
				},
			},

			css: {
				files: [ 'assets/src/sass/**/*.scss' ],
				tasks: [ 'styles' ],
				options: {
					spawn: false,
				},
			},

			images: {
				files: [ 'assets/src/img/*' ],
				tasks: [ 'imagemin' ],
				options: {
					spawn: false,
				},
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
					potFilename: 'theme.pot',		// Name of the POT file.
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
	grunt.registerTask( 'styles', [
		'sass',
		'postcss',
	] );
	grunt.registerTask( 'javascript', [
		//'eslint',
		'concat',
		'uglify'
	] );
	grunt.registerTask( 'svg', [
		'svgmin',
		'svgstore', // uncomment if using svg sprite system
	] );
	grunt.registerTask( 'images', [ 'imagemin' ] );
	grunt.registerTask( 'i18n', [ 'makepot' ] );
	grunt.registerTask( 'bump-patch', [ 'version::patch' ] );
	grunt.registerTask( 'bump-minor', [ 'version::minor' ] );
	grunt.registerTask( 'bump-major', [ 'version::major' ] );
	grunt.registerTask( 'default', [
		'styles',
		'javascript',
		'svg',
		'images',
		'i18n',
		'bump-patch'
	] );
};
