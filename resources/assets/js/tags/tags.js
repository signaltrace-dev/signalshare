var tagger = {};

$(document).ready(function(){
    tagger.getTags = function(targetType, targetId){
        var url = targetType + '/' + targetId + '/tags';
    };

    tagger.attachTag = function(targetType, targetId, tagId){
        var url = '/tags/attach';
        var data = {
            tagId: tagId,
            targetId: targetId,
            targetType: targetType,
        };

        $.ajax({
            type: "POST",
            data: data,
            url: url,
            success: function(data) {

            }
        })
        .done(function(data) {
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
        });
    };

    tagger.detachTag = function(targetType, targetId, tagId){
        var url = '/tags/detach';
        var data = {
            tagId: tagId,
            targetId: targetId,
            targetType: targetType,
        };

        $.ajax({
            type: "POST",
            data: data,
            url: url,
            success: function(data) {

            }
        })
        .done(function(data) {
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
        });
    };
});
