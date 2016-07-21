<template id="user_template">

<div class="container">
    <div class="panel">
        <h2>{{user.name}}</h2>
        <div class="row">
            <div class="col-xs-4">
                <img :src="user.avatar" class="img-responsive img-rounded">
            </div>
            <div class="col-xs-8">
                <button class="btn btn-success btn-lg" @click="toggleFollowUser">{{user.isFollowed? '取消关注':'关注'}}</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p></p>
                <p>
                    获得 <span class="glyphicon glyphicon-thumbs-up"> </span>{{user.inputLikeCount}}赞同
                    <span class="text-muted">|</span>
                    关注了 <span class="glyphicon glyphicon-user"></span> {{user.followCount}} 人
                    <span class="text-muted">|</span>
                    关注者 <span class="glyphicon glyphicon-heart"></span> {{user.followedCount}} 人

                </p>
                <p>
                    发表评论<span class="glyphicon glyphicon-comment"></span>
                    <a href="/user/{{user.id}}/input">{{user.inputCount}} 篇</a>
                </p>

            </div>

        </div>
    </div>
</div>


</template>

<script>

    export default {
        props: ['user'],

        created() {
            this.user = JSON.parse(this.user);
        },

        data: function() {
            return {
            };

        },

        methods:{
            toggleFollowUser(){
                var action = this.user.isFollowed ? 'unfollow' : 'follow';
                this.$http.get('/user/' + this.user.id + '/' + action).then(
                        function(response) {
                            console.log(response);
                        },
                        function(response) {
                            this.user.isFollowed = ! this.user.isFollowed;
                        }
                );
                this.user.isFollowed = ! this.user.isFollowed;
            },

        }
    }
</script>