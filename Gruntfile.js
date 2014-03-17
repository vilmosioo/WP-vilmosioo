'use strict';

/* globals require, module */

module.exports = function(grunt) {
	// load all grunt tasks
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	var pkg = grunt.file.readJSON('package.json');

	// Project configuration.
	grunt.initConfig({
		pkg: pkg,
		config: pkg.config || {
			app: 'app',
			dist: 'dist'
		},
		clean: {
			dist: ['<%= config.dist %>']
		},
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= config.app %>/js/*.js',
				'!<%= config.app %>/**/*.min.js'
			]
		},
		watch: {
			general: {
				files: ['<%= config.app %>/**/*.html', '<%= config.app %>/**/*.php'],
				tasks: ['newer:copy', 'newer:replace']
			},
			js: {
				files: ['<%= config.app %>/js/**/*.js'],
				tasks: ['newer:uglify', 'newer:replace']
			},
			sass: {
				files: ['<%= config.app %>/**/*.scss'],
				tasks: ['compass', 'newer:cssmin', 'newer:replace']
			}
		},
		compass: {
			dist: {
				options: {
					sassDir: '<%= config.app %>',
					cssDir: '.tmp',
					importPath: 'components/bootstrap-sass/lib'
				}
			}
		},
		cssmin: {
			options: {
				keepSpecialComments: 1
			},
			minify: {
				expand: true,
				cwd: '.tmp',
				src: '**/*.css',
				dest: '<%= config.dist %>'
			}
		},
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> - v<%= pkg.version %> */',
				preserveComments: false
			},
			dist: {
				files: {
					'<%= config.dist %>/js/play.js': '<%= config.app %>/js/play.js',
					'<%= config.dist %>/js/gameoflife.js': [
						'components/screenfull/dist/screenfull.js',
						'<%= config.app %>/js/gameoflife.js'
					],
					'<%= config.dist %>/js/webgl.js': [
						'components/threejs/build/three.min.js',
						'components/threejs/examples/js/controls/TrackballControls.js',
						'<%= config.app %>/js/webgl.js'
					]
				}
			},
			combine: {
				files: {
					'<%= config.dist %>/js/script.js': [
						'<%= config.app %>/js/script.js',
						'.tmp/js/modernizr.js'
					]
				}
			}
		},
		copy: {
			dist: {
				expand: true,
				cwd: '<%= config.app %>',
				src: [
					'**/*.{php,html,css,ico,txt}',
					'**/*.{png,jpg,jpeg,gif}',
					'**/*.{webp,svg}',
					'**/*.{eot,svg,ttf,woff}',
					'**/*.{stl,md}'
				],
				dest: '<%= config.dist %>'
			},
			jquery: {
				expand: true,
				cwd: 'components',
				src: [
					'jquery/jquery.min.js',
				],
				dest: '<%= config.dist %>/js/vendor'
			},
			components: {
				expand: true,
				cwd: 'components/wordpress-tools',
				src: [
					'**/*'
				],
				dest: '<%= config.dist %>/inc'
			},
			sftp:{
				src: '<%= config.app %>/.sftp-config.json',
				dest: '<%= config.dist %>/sftp-config.json'
			}
		},
		modernizr: {
			devFile: "components/modernizr/modernizr.js",
			outputFile: ".tmp/js/modernizr.js",
			files: [
				'app/**/*'
			]
		},
		replace: {
			options: {
				variables: {
					'version': pkg.version || '0.0.1'
				}
			},
			files: {
				expand: true,
				cwd: '<%= config.dist %>',
				src: '**/*',
				dest: '<%= config.dist %>'
			}
		},
		'ftp-deploy': {
			build: {
				auth: {
					host: 'vilmosioo.co.uk',
					port: 21,
					authKey: 'user'
				},
				src: 'dist',
				dest: '/',
				exclusions: []
			}
		}
	});

	grunt.registerTask('build', [
		'clean', // delete dist folder
		'jshint', // validate all js files
		'compass', // process all scss file and dump result in .tmp
		'cssmin', // minify all css files from app folder and move them to dist folder
		'modernizr', // parse mdoernizr and copy only necessary tests
		'uglify', // uglify all JS files from app folder and move them to in the dist folder
		'copy', // copy rest of files from app folder to dist (php ,html, txt, ico, fonts) and copy components in dist
		'replace' // replaces and inserts the theme version
	]);

	grunt.registerTask('server', [
		'watch'
	]);

	// Default task(s).
	grunt.registerTask('default', ['build']);

};