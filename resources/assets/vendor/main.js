/**
 * Created by Jean on 028 28 01 2015.
 */


$(function() {
    var mdEditors = $('*[data-editor="epiceditor"]');

    mdEditors.each(function(item) {
        var obj = $(this);

        new EpicEditor(obj);
    })
});