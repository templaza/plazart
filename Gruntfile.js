module.exports = function(grunt) {

    var configBridge = grunt.file.readJSON('./configBridge.json', { encoding: 'utf8' });

    // Project configuration.
    grunt.initConfig({

        plazartadmin: configBridge.config.plazart_admin.join('\n'),
        plazartbase: configBridge.config.plazart_base.join('\n'),
        plazartincludes: configBridge.config.plazart_includes.join('\n'),
        tplcss: configBridge.config.tpl_css.join('\n'),
        tplless: configBridge.config.tpl_less.join('\n'),
        tpl_bootstrap: configBridge.config.tpl_bootstrap.join('\n'),


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
            less: {
                files: ['<%= tplless %>/themes/default/*.less'],
                tasks: ['less-compile']
            },
            importless: {
                files: ['<%= tplless %>/import/default/*.less'],
                tasks: ['less-compile']
            }
        },

        less: {
            template: {
                options: {
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
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'megamenu.css.map',
                    sourceMapFilename: '<%= tplcss %>/themes/default/megamenu.css.map'
                },
                src: '<%= tplless %>/themes/default/megamenu.less',
                dest: '<%= tplcss %>/themes/default/megamenu.css'
            },
            others: {
                files: {
                    "<%= tplcss %>/themes/default/offline.css": "<%= tplless %>/themes/default/offline.less",
                    "<%= tplcss %>/themes/default/print.css": "<%= tplless %>/themes/default/print.less"
                }
            },
            bootstrap: {
                options: {
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'bootstrap.css.map',
                    sourceMapFilename: '<%= tpl_bootstrap %>/css/bootstrap.css.map'
                },
                src: './less/bootstrap/bootstrap.less',
                dest: '<%= tpl_bootstrap %>/css/bootstrap.css'
            },
            bootstrap_rtl: {
                options: {
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'bootstrap-rtl.css.map',
                    sourceMapFilename: '<%= tpl_bootstrap %>/css/bootstrap-rtl.css.map'
                },
                src: './less/bootstrap-rtl/bootstrap-rtl.less',
                dest: '<%= tpl_bootstrap %>/css/bootstrap-rtl.css'
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
                keepSpecialComments: false,
                advanced: false
            },
            minifyCore: {
                src: '<%= tpl_bootstrap %>/css/bootstrap.css',
                dest: '<%= tpl_bootstrap %>/css/bootstrap.min.css'
            },
            minifyRtl: {
                src: '<%= tpl_bootstrap %>/css/bootstrap-rtl.css',
                dest: '<%= tpl_bootstrap %>/css/bootstrap-rtl.min.css'
            },
            minifyRtlLegacy: {
                src: '<%= plazartbase %>/bootstrap/legacy/css/bootstrap-rtl.css',
                dest: '<%= plazartbase %>/bootstrap/legacy/css/bootstrap-rtl.min.css'
            },
            minifyAdmin: {
                src: '<%= plazart_admin %>/css/admin.css',
                dest: '<%= plazart_admin %>/css/admin.min.css'
            },
            minifyLayout: {
                src: '<%= plazart_admin %>/css/admin-layout.css',
                dest: '<%= plazart_admin %>/css/admin-layout.min.css'
            },
            minifySpectrum: {
                src: '<%= plazart_admin %>/css/spectrum.css',
                dest: '<%= plazart_admin %>/css/spectrum.min.css'
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
    grunt.registerTask('less-compile', ['less:template', 'less:megamenu', 'less:others']);
    grunt.registerTask('less-bootstrap', ['less:bootstrap', 'less:bootstrap_rtl','cssmin:minifyCore', 'cssmin:minifyRtl']);
    grunt.registerTask('minify-bootstrap', ['cssmin:minifyCore', 'cssmin:minifyTheme']);
    grunt.registerTask('minify-admin', ['cssmin:minifyAdmin', 'cssmin:minifyLayout', 'cssmin:minifySpectrum']);
    grunt.registerTask('minify-all', ['cssmin:all']);
    grunt.registerTask('minifyjs-bootstrap', ['uglify:bootstrap']);
    grunt.registerTask('concat-js-bootstrap', ['concat:catscript']);
    grunt.registerTask('watch-less', ['watch:less']);
    grunt.registerTask('minify_rtl_legacy', ['cssmin:minifyRtlLegacy']);

};