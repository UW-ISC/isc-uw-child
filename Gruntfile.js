module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
        jshint: {
            files: ['Gruntfile.js', 'assets/js/*.js', 'package.json'],
        },
        phpcs: {
            application: {
                src: ['*.php', '**/*.php']
            },
            options: {
                bin: '/usr/bin/phpcs'
            }
        },
		sass: {
			dist: {
				files: {
					'isc-styles.css' : 'assets/sass/isc-styles.scss'
				}
			}
		},
		watch: {
			css: {
				files: '**/*.scss',
				tasks: ['sass']
			},
            javascript: {
                files: ['<%= jshint.files %>'],
                tasks: ['changed:jshint']
            },
            php: {
                files: ['*.php','**/*.php'],
                tasks: ['changed:phpcs']
            }
		}
	});
	grunt.loadNpmTasks('grunt-changed');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-phpcs');
	grunt.registerTask('default',['watch']);
};
