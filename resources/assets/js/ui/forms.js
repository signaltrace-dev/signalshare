$(document).ready(function(){
    $(".chosen-select").chosen();

    if($('.user-form').length > 0){
        var vue = new Vue({
            el: '.user-form',
            data:{
                userName: '',
                userNameExists: false,
            },
            computed: {
                userNameValid: function(){
                    var isValid = true;

                    if(this.userName){
                        isValid = !this.userNameExists;
                    }
                    return isValid;
                }
            },
            watch: {
                userName: function(newName){
                    vue.userNameExists = false;
                    if(newName.length >= 4){
                        $.ajax({
                            url: "/people/" + newName + "/exists",
                            error: function(){

                            },
                        }).done(function(data){
                            vue.userNameExists = (data && data.name);
                        });
                    }
                }
            }
        });
    }
});
