module.exports = function(grunt) {

    var configBridge = grunt.file.readJSON('./configBridge.json', { encoding: 'utf8' });

    // Project configuration.
    grunt.initConfig({

        plazartadmin: configBridge.config.plazart_admin.join('\n'),
        plazartbase: configBridge.config.plazart_base.join('\n'),
        plazartincludes: configBridge.config.plazart_includes.join('\n'),
        tplcss: configBridge.config.tpl_css.join('\n'),
        tplless: configBridge.config.tpl_less.join('\n'),


        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            plazart_admin: [
                '<%= plazartadmin %>/js/layout.admin.js',
                '<%= plazartbase %>/js/*.js',
                '!<%= plazartbase %>/js/*.min.js'
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
            template: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'template.css.map',
                    sourceMapFilename: '<%= tplcss %>/themes/default/template.css.map'
                },
                src: '<%= tplless %>/themes/default/template.less',
                dest: '<%= tplcss %>/themes/default/template.css'
            },
            megamenu: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'megamenu.css.map',
                    sourceMapFilename: '<%= tplcss %>/themes/default/megamenu.css.map'
                },
                src: '<%= tplless %>/themes/default/megamenu.less',
                dest: '<%= tplcss %>/themes/default/megamenu.css'
            },
            megamenuresponsive: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'megamenu.css.map',
                    sourceMapFilename: '<%= tplcss %>/themes/default/megamenu-responsive.css.map'
                },
                src: '<%= tplless %>/themes/default/megamenu-responsive.less',
                dest: '<%= tplcss %>/themes/default/megamenu-responsive.css'
            },
            others: {
                files: {
                    "<%= tplcss %>/themes/default/offline.css": "<%= tplless %>/themes/default/offline.less",
                    "<%= tplcss %>/themes/default/print.css": "<%= tplless %>/themes/default/print.less"
                }
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
    grunt.registerTask('less-compile', ['less:template', 'less:megamenu', 'less:megamenuresponsive', 'less:others']);
    grunt.registerTask('minify-bootstrap', ['cssmin:minifyCore', 'cssmin:minifyTheme']);
    grunt.registerTask('minify-all', ['cssmin:all']);
    grunt.registerTask('minifyjs-bootstrap', ['uglify:bootstrap']);
    grunt.registerTask('concat-js-bootstrap', ['concat:catscript']);

};