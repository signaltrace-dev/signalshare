import tagger from '../components/Tagger.vue';

window.onload = function(){
   const app = new Vue({
       el: '#tagger',
       components:{
           tagger
       }
   });
}
