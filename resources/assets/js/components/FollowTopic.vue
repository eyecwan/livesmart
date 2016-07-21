<template id="follow_template">


    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <h2>{{topic.name}}</h2>
                    <button class="btn btn-success" @click="toggleFollowTopic(topic)" v-show="false">{{topic.followed? '取消关注':'关注他'}}</button>
                    <a class="btn btn-success btn-lg btn-block" role="button" href="{{'/topic/'+ topic.id +'/input/create'}}">写评论</a>

                </div>
            </div>
        </div>
    </div>





</template>

<script>

    export default {
        props: ['topic'],

        created() {
            this.topic = JSON.parse(this.topic);
        },

        data: function() {
            return {
                btnStyle:''
            };

        },

        methods:{
            followTopic(topic) {
                this.$http.get('/topic/' + topic.id + '/follow').then(
                        (response) =>{
                        console.log(response);

                    }, (response) => {
                        console.log(response);
                    this.topic.followed = false;
                    }
                );
            },

            unfollowTopic(topic) {
                this.$http.get('/topic/' + topic.id + '/unfollow').then(
                        (response) => {
                    console.log(response);
                },(response) => {
                    console.log(response);
                    this.topic.followed = true;
                }
                );
            },

            toggleFollowTopic(topic) {
                if(this.topic.followed){
                    this.unfollowTopic(topic);
                } else {
                    this.followTopic(topic);
                }
                this.topic.followed = ! this.topic.followed;
            }


        }
    }
</script>