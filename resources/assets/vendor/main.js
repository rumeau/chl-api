/**
 * Created by Jean on 028 28 01 2015.
 */


$(function() {
    var mdEditors = $('*[data-editor="epiceditor"]'),
        prettyfy = $('pre code[class^="language-"]');

    mdEditors.each(function(item) {
        var obj = $(this);

        new EpicEditor({
            basePath: '/epiceditor',
            container: obj.prop('id') + '-container',
            textarea: obj.prop('id'),
            theme: {
                editor: '/themes/editor/epic-light.css'
            },
            clientSideStorage: false
        }).load();

        obj.hide();
    });

    prettyfy.each(function(i, block) {
        hljs.highlightBlock(block);
    });

});