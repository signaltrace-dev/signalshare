<template>
    <div>
        <div class="box" v-show="tags.length > 0">
            <div class="tag-list">
                <span class="tag is-success" v-for="tag in tags">
                    {{ tag.name }}
                    <button v-on:click="detach(tag.id)" class="delete"></button>
                </span>
            </div>
        </div>
        <p class="control has-addons has-addons-centered">
            <input class="input" ref="searchBox" type="text" name="tagname" v-model="searchText" v-on:keyup.enter="attach" v-on:keyup="search" id="txt-tag-search">
            <button class="button is-success" id="btn-attach-tag" v-on:click="attach" name="button">Add</button>
        </p>
    </div>
</template>

<script>
export default {
    name: 'tagger',
    props:{
        targetobj: {
            type: String,
            required: true,
        },
        targettype: {
            type: String,
            default: 'projects',
        },
        tagtype: {
            type: String,
            default: 'tags',
        },
    },
    data: function(){
        return{
            tags: [],
            searchText: '',
            searchButton: {},
            awesomplete: {},
        }
    },
    computed: {
            target: function(){
                return JSON.parse(this.targetobj);
            },
            title: function(){
                var title = this.tagtype;
                title = title.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
                return title;
            },
            titleSingular: function(){
                var title = this.title;
                return pluralize.singular(title);
            }
    },
    methods: {
        attach: function(){
            var tagger = this;

            if(this.searchText){
                var url = '/' + this.tagtype + '/attach';
                var data = {
                    name: this.searchText,
                    targetid: this.target.id,
                    targettype: this.targettype,
                    tagtype: this.tagtype,
                };

                $.ajax({
                    type: "POST",
                    data: data,
                    url: url,
                    success: function(data) {
                        tagger.tags = data.attached;
                        tagger.searchText = '';
                    }
                })
            }
        },
        detach: function(tagId){
            var tagger = this;
            var url = '/' + this.tagtype + '/detach';
            var data = {
                id: tagId,
                targetid: this.target.id,
                targettype: this.targettype,
            };

            $.ajax({
                type: "POST",
                data: data,
                url: url,
                success: function(data) {
                    tagger.tags = data.attached;
                }
            })
        },
        search: function(){
            var tagger = this;

            $.ajax({
                url: '/' + this.tagtype + '/search/autocomplete?query=' + tagger.searchText,
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
            var url = '/' + this.targettype + '/' + this.target.owner.name + '/' + this.target.slug + '/' + this.tagtype;
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
