var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: 'sys', files: ['application.js']},
        {name: '{C#MODNAME}', files: ['model.js']}
    ]
};
Component.entryPoint = function(NS){

    NS.roles = new Brick.AppRoles('{C#MODNAME}', {
        isAdmin: 50,
        isWrite: 30,
        isView: 10
    });

    var COMPONENT = this,
        SYS = Brick.mod.sys;

    SYS.Application.build(COMPONENT, {}, {
        initializer: function(){
            NS.roles.load(function(){
                this.initCallbackFire();
            }, this);
        }
    }, [], {
        REQS: {
            file: {
                attribute: true,
                type: 'model:File',
            },
            config: {
                attribute: true,
                type: 'model:Config'
            },
            configSave: {
                args: ['config']
            }
        },
        ATTRS: {
            isLoadAppStructure: {value: true},
            File: {value: NS.File},
            FileList: {value: NS.FileList},
            Config: {value: NS.Config}
        },
        URLS: {
            ws: "#app={C#MODNAMEURI}/wspace/ws/",
            upload: {
                view: function(){
                    return this.getURL('ws') + 'upload/UploadWidget/'
                }
            },
            config: function(){
                return this.getURL('ws') + 'config/ConfigWidget/';
            }
        }
    });
};