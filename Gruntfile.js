'use strict';
module.exports = function(grunt){

	// load all tasks
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
	    makepot: {
	        target: {
	            options: {
	                domainPath: '/languages/',    // Where to save the POT file.
	                potFilename: '<%= pkg.name %>.pot',   // Name of the POT file.
	                type: 'wp-theme'  // Type of project (wp-plugin or wp-theme).
	            }
	        }
	    },
	    clean: {
	    	build: {
	    		src: ['build/']
	    	},
	    	release: {
	    		src: ['release/']
	    	}
	    },
	    copy: {
	    	readme: {
	    		src: 'readme.md',
	    		dest: 'build/readme.txt'
	    	},
	    	build: {
	    		expand: true,
	    		src: ['**', '!node_modules/**', '!build/**', '!readme.md', '!Gruntfile.js', '!package.json' ],
	    		dest: 'build/'
	    	}
	    },
	    compress: {
	    	build: {
	    		options: {
	    			archive: 'release/<%= pkg.name %>.zip'
	    		},
	    		expand: true,
	    		cwd: 'build/',
                src: ['**/*'],
	    		dest: '<%= pkg.name %>/'
	    	}
	    }
    });

    grunt.registerTask('default', []);

    // Build task
    grunt.registerTask( 'release', [ 
    	'makepot',
    	'clean', 
    	'copy',
    	'compress:build',
    	'clean:build'
	]);    
};