module.exports = function(grunt) {
    "use strict";

    grunt.initConfig({
        "less": {
            "development": {
                files: {
                    "public/css/meetspire.css": "./assets/less/meetspire/meetspire.less"
                }
            }
        },
        "watch": {
            "all": {
                files : [
                    "./less/**/*.less"
                ],
                tasks : [
                    "less:development"
                ]
            },
            "less": {
                files : [
                    "less/**/*.less"
                ],
                tasks : ["less:development"]
            }
        },
        "lesslint": {
            "meetspire": [
                'assets/less/**/*.less'
            ]
        }
    });

    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-lesslint");
    grunt.loadNpmTasks("grunt-contrib-watch");

    grunt.registerTask('build', ['less']);
//    grunt.registerTask('build', ['lesslint', 'less']);
};
