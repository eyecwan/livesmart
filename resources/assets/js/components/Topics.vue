<template id="topics_template">

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="panel panel-default" v-for="topic in topics">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-8">
                                {{topic.name}}
                            </div>
                            <div class="col-xs-4">
                                <button class="btn btn-success pull-right" @click="toggleFollowTopic(topic)">{{topic.isFollowed? '取消关注':'关注'}}</button>
                            </div>
                        </div>

                    </div>

                    <div class="panel-body">
                        {{topic.description}}
                        <a href="/topic/{{topic.id}}">more</a>
                    </div>

                </div>
            </div>
        </div>
    </div>


</template>

<script>

    export default {
        props: ['topics'],

        created() {
            this.topics = JSON.parse(this.topics);
        },

        data: function() {
            return {
            };

        },

        methods:{
            followTopic(topic) {
                this.$http.get('/topic/' + topic.id + '/follow').then(
                        (response) =>{
                    console.log(response);

            }, (response) => {
                    console.log(response);
                    topic.isFollowed = false;
                }
            );
            },

            unfollowTopic(topic) {
                this.$http.get('/topic/' + topic.id + '/unfollow').then(
                        (response) => {
                    console.log(response);
            },(response) => {
                    console.log(response);
                    topic.isFollowed = true;
                }
            );
            },

            toggleFollowTopic(topic) {
                if(topic.isFollowed){
                    this.unfollowTopic(topic);
                } else {
                    this.followTopic(topic);
                }
                topic.isFollowed = ! topic.isFollowed;
            }

        }
    }
</script>