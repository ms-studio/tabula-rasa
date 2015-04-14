module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
				
				clean: [
					'css/build/*.css'
				],
				
				timestamp: grunt.template.today("yyyymmddHHMMss"),  // Arbitrary property
				        
        // Combine & Minify CSS
        cssmin: {
          combine: {
          	options: {
          	      banner: '/*! styles for <%= pkg.name %> - generated <%= grunt.template.today("yyyy-mm-dd") %> */\n'
          	    },
            files: {
              'css/build/styles.<%= timestamp %>.css': ['css/dev/00-main.css']
            }
          }
        },
        

        // Update the register_styles function
        replace: {
          scripts: {
            src: ['functions.php'],
            overwrite: true, 
            replacements: [{
            	from: /css\/build\/styles\.(\d+)\.css/,
            	to: 'css/build/styles.<%= timestamp %>.css'
            }, {
            	from: /Change-Detector-X/,
            	to: 'Change-Detector-XX'
            }]
          }
        }

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    // grunt.loadNpmTasks('grunt-contrib-concat');
    // grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-text-replace');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', [
    	'clean',
    	'cssmin',
    	// 'concat',
    	// 'uglify',
    	'replace'
    ]);

};