var tagger = {};

$(document).ready(function(){
    tagger.data = new Vue({
        el: '#tagger',
        data: {
            tags: [],
        },
        methods: {
            detach: function(targetType, targetId, tagId){
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
                        tagger.data.tags = data.tags;
                    }
                })
                .done(function(data) {
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                });
            },
        }
    });

    tagger.search = document.getElementById('txt-tag-search');

    tagger.awesomplete = new Awesomplete(tagger.search, {
        minChars: 2,
        autoFirst: true,
    });

    $(tagger.search).on('keyup', function(){
        $.ajax({
            url: '/tags/search/autocomplete?query=' + this.value,
            type: 'GET',
            dataType: 'json',
        }).done(function(data){
            var list = [];
            $.each(data, function(key, value) {
              list.push(value.name);
            });
            tagger.awesomplete.list = list;
        });
    });

    tagger.getTags = function(targetType, targetId){
        var url = '/' + targetType + '/' + targetId + '/tags';
        $.ajax({
            url: url,
            type: 'GET',
        }).done(function(data){
            var list = [];
            $.each(data, function(key, value) {
                tagger.data.tags.push(value);
            });
        });
    };

    tagger.attachTag = function(targetType, targetId, tagName){
        var url = '/tags/attach';
        var data = {
            tagname: tagName,
            targetid: targetId,
            targettype: targetType,
        };

        $.ajax({
            type: "POST",
            data: data,
            url: url,
            success: function(data) {
                tagger.data.tags = data.tags;
            }
        })
        .done(function(data) {
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
        });
    };

});
