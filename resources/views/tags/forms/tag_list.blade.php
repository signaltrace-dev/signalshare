<template v-for="tag in tags">
    <div class="btn btn-info">
        <span v-text="tag.name"></span>
        <button v-on:click="detach('project', '{{ $project->id }}', tag.id)" class="link-delete"><i class="fa fa-times"></i></button>
    </div>
</template>
