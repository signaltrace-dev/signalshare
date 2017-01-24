<template>
    <div class="panel panel-brand">
        <div class="panel-heading">
            <h3 class="panel-title">Tags</h3>
        </div>
        <div class="panel-body">
            <div class="tag-list">
                <span class="label label-primary tag" v-for="tag in tags">
                    {{ tag.name }}
                    <button v-on:click="detach(tag.id)" class="link-delete"><i class="fa fa-times"></i></button>
                </span>
            </div>

            <input ref="searchBox" type="text" name="tagname" v-model="searchText" v-on:keyup.enter="attach" v-on:keyup="search" id="txt-tag-search">
            <button class="btn btn-success" id="btn-attach-tag" v-on:click="attach" name="button">Assign Tag</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'tagger',
    props:{
        targetname: '',
        targetid: '',
        targettype: '',
    },
    data: function(){
        return{
            tags: [],
            searchText: '',
            searchButton: {},
            awesomplete: {},
        }
    },
    methods: {
        attach: function(){
            var tagger = this;

            if(this.searchText){
                var url = '/tags/attach';
                var data = {
                    tagname: this.searchText,
                    targetid: this.targetid,
                    targettype: this.targettype,
                };

                $.ajax({
                    type: "POST",
                    data: data,
                    url: url,
                    success: function(data) {
                        tagger.tags = data.tags;
                        tagger.searchText = '';
                    }
                })
            }
        },
        detach: function(tagId){
            var tagger = this;
            var url = '/tags/detach';
            var data = {
                tagId: tagId,
                targetId: this.targetid,
                targetType: this.targettype,
            };

            $.ajax({
                type: "POST",
                data: data,
                url: url,
                success: function(data) {
                    tagger.tags = data.tags;
                }
            })
        },
        search: function(){
            var tagger = this;

            $.ajax({
                url: '/tags/search/autocomplete?query=' + tagger.searchText,
                type: 'GET',
                dataType: 'json',
            }).done(function(data){
                var list = [];
                $.each(data, function(key, value) {
                    // Only show tags that aren't already assigned
                    var found = tagger.tags.filter(function(obj){
                        return obj.name === value.name;
                    });
                    if(found.length == 0){
                        list.push(value.name);
                    }
                });
                tagger.awesomplete.list = list;
            });
        },
        getTags: function(){
            var tagger = this;
            var url = '/' + this.targettype + '/' + this.targetname + '/tags';
            $.ajax({
                url: url,
                type: 'GET',
            }).done(function(data){
                var list = [];
                $.each(data, function(key, value) {
                    tagger.tags.push(value);
                });
            });
        },
    },
    mounted(){
        var tagger = this;
        this.getTags();
        var searchBox = this.$refs.searchBox;

        this.awesomplete = new Awesomplete(searchBox, {
            minChars: 2,
            autoFirst: true,
        });

        $(searchBox).on('awesomplete-selectcomplete', function(e, data){
            tagger.searchText = this.value;
            tagger.attach();
        });
    }
}
</script>

<style lang="css">
</style>
