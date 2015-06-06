module.exports = function(grunt) {
	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		autoprefixer: {
			options: {
			},
			no_dest: {
				src : 'public/css/boomcms-installer.css'
			}
		},
		concat: {
			options: {
				separator: ';',
				process: function(src, filepath) {
				  return src.replace(/@VERSION/g, grunt.config.get('pkg.version'));
				}
			},
			dist: {
	  			src: [

				],
				dest: 'public/js/boomcms-installer.js'
			}
		},
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> - v<%= pkg.version %> (<%= grunt.template.today("yyyy-mm-dd") %>) */\n',
				sourceMap: true
			},
			build: {
				files: {
					'public/js/boomcms-installer.js': 'public/js/boomcms-installer.js'
				}
			}
		},
		less: {
			production: {
				options: {
					paths: ["src/css"]
				},
				files: {
					"public/css/boomcms-installer.css": "src/css/boomcms-installer.less"
				}
			}
		},
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: {
					 'public/css/boomcms-installer.css': [
						'public/css/boomcms-installer.css'
					 ]
				}
			}
		},
		watch: {
			css: {
				files: 'src/css/**/*.less',
				tasks: ['build-css']
			},
			js: {
				files: 'src/js/**/*.js',
				tasks: ['build-js']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-autoprefixer');

	grunt.registerTask('build-css', ['less', 'autoprefixer:no_dest', 'cssmin']);
	grunt.registerTask('build-js', ['concat:dist']);
	grunt.registerTask('dist', ['build-css', 'build-js', 'uglify']);
	grunt.registerTask('default',['watch']);
};
