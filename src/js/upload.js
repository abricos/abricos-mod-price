var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: 'filemanager', files: ['attachment.js']},
        {name: '{C#MODNAME}', files: ['newsList.js', 'lib.js']}
    ]
};
Component.entryPoint = function(NS){

    var Y = Brick.YUI,
        COMPONENT = this,
        SYS = Brick.mod.sys;

    var counter = 1;

    NS.UploadWidget = Y.Base.create('uploadWidget', SYS.AppWidget, [], {
        onInitAppWidget: function(err, appInstance, options){
            this._idWidget = counter++;
            NS.UploadWidget._activeWidgets[this._idWidget] = this;

            this.reloadFile();
        },
        destructor: function(){
            delete NS.UploadWidget._activeWidgets[this._idWidget];
        },
        reloadFile: function(){
            this.set('waiting', true);
            this.get('appInstance').file(function(err, result){
                this.set('waiting', false);
                if (!err){
                    this.renderFile(result.file);
                }
            }, this);
        },
        renderFile: function(file){
            if (file){
                this.set('file', file);
            }
            file = file || this.get('file');

            if (!file){
                return;
            }
            var tp = this.template;

            tp.setHTML('file', tp.replace('file', file.toJSON()));
        },
        upload: function(){
            var idWidget = this._idWidget,
                url = '/price/upload/' + idWidget + '/';

            this.uploadWindow = window.open(
                url, 'catalogimage',
                'statusbar=no,menubar=no,toolbar=no,scrollbars=yes,resizable=yes,width=480,height=270'
            );
        },
        setFile: function(){
            this.reloadFile();
        }
    }, {
        ATTRS: {
            component: {value: COMPONENT},
            templateBlockName: {value: 'widget,file'}
        },
        CLICKS: {
            upload: 'upload'
        }
    });

    NS.UploadWidget._activeWidgets = {};

    NS.UploadWidget._setFile = function(idWidget, filehash){
        var w = NS.UploadWidget._activeWidgets[idWidget];
        if (!w){
            return;
        }
        w.setFile(filehash);
    };
};