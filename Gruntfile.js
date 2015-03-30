module.exports = function(grunt) {

    var configBridge = grunt.file.readJSON('./configBridge.json', { encoding: 'utf8' });

    // Project configuration.
    grunt.initConfig({

        plazartadmin: configBridge.config.plazart_admin.join('\n'),
        plazartbase: configBridge.config.plazart_base.join('\n'),
        plazartincludes: configBridge.config.plazart_includes.join('\n'),

        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            plazart_admin: [
                '<%= plazartadmin %>/js/layout.admin.js'
            ]
        },

        uglify: {
            bootstrap: {
                options: {
                    sourceMap: true,
                    sourceMapName: '<%= yourjsfiles %>/script.js.map'
                },
                files: {
                    '<%= yourjsfiles %>/script.min.js': ['<%= yourjsfiles %>/alert.js','<%= yourjsfiles %>/button.js']
                }
            }
        },

        concat: {
            catscript: {
                src: [
                    '<%= yourjsfiles %>/*.js'
                ],
                dest: '<%= yourjsfiles %>/allscript.js'
            }
        },

        watch: {
            jsfiles: {
                files: ['<%= yourjsfiles %>/*.js'],
                tasks: ['jshint:alljs']
            }
        },

        less: {
            compileCore: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'bootstrap.css.map',
                    sourceMapFilename: '<%= yourcss %>/bootstrap.css.map'
                },
                src: '<%= yourless %>/bootstrap.less',
                dest: '<%= yourcss %>/bootstrap.css'
            },
            compileTheme: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'bootstrap-theme.css.map',
                    sourceMapFilename: '<%= yourcss %>/bootstrap-theme.css.map'
                },
                src: '<%= yourless %>',
                dest: '<%= yourcss %>/bootstrap-theme.css'
            }
        },

        autoprefixer: {
            options: {
                browsers: configBridge.config.autoprefixerBrowsers
            },
            core: {
                options: {
                    map: true
                },
                src: '<%= yourcss %>/bootstrap.css'
            },
            theme: {
                options: {
                    map: true
                },
                src: '<%= yourcss %>/bootstrap-theme.css'
            }
        },

        cssmin: {
            options: {
                compatibility: 'ie8',
                //keepSpecialComments: '*',
                advanced: false
            },
            minifyCore: {
                src: '<%= yourcss %>/bootstrap.css',
                dest: '<%= yourcss %>/bootstrap.min.css'
            },
            minifyTheme: {
                src: '<%= yourcss %>/bootstrap-theme.css',
                dest: '<%= yourcss %>/bootstrap-theme.min.css'
            },
            all: {
                files: [{
                    expand: true,
                    cwd: '<%= yourcss %>',
                    src: ['*.css', '!*.min.css', '!*.css.map'],
                    dest: '<%= yourcss %>',
                    ext: '.min.css'
                }]
            }
        },

        usebanner: {
            options: {
                position: 'top',
                banner: '<%= topBanner %>'
            },
            files: {
                src: '<%= yourcss %>/*.css'
            }
        },

        csslint: {
            options: {
                csslintrc: '.csslintrc'
            },
            dist: [
                '<%= yourcss %>/bootstrap.css',
                '<%= yourcss %>/bootstrap-theme.css'
            ]
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-csslint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-banner');
    grunt.loadNpmTasks('grunt-jsvalidate');

    // Load tasks.
    //require('matchdep').filterDev(['grunt-*', '!grunt-legacy-util']).forEach( grunt.loadNpmTasks );

    grunt.registerTask('plazat-hint', ['jshint:plazart_admin']);
    grunt.registerTask('less-bootstrap', ['less:compileCore', 'less:compileTheme', 'usebanner:files']);
    grunt.registerTask('minify-bootstrap', ['cssmin:minifyCore', 'cssmin:minifyTheme']);
    grunt.registerTask('minify-all', ['cssmin:all']);
    grunt.registerTask('minifyjs-bootstrap', ['uglify:bootstrap']);
    grunt.registerTask('concat-js-bootstrap', ['concat:catscript']);

};