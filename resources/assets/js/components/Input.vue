<template id="inputs-template">


    <div class="container">

        <ul class="list-group">


            <p class="text-right">
                <span @click="sortByWords" class="{{textStyleWords}}">内容多的 </span>|
                <span @click="sortByLikes" class="{{textStyleLikes}}">点赞高的 </span>|
                <span @click="sortById" class="{{textStyleId}}">最新的 </span>
            </p>




            <li class="list-group-item" v-for="input in list | orderBy order -1 ">

                <div v-if="input.topic" class="row">
                    <div class="col-xs-12">
                        <h4>{{input.topic.name}}</h4>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-2">
                        <div>
                            <img :src="input.user.avatar" class="img-circle img-responsive">
                        </div>

                    </div>
                    <div class="col-xs-10">
                        <div class="row">
                            <div class="col-xs-10">
                                <a href="/user/{{input.user_id}}">{{input.user.name}}</a>
                            </div>
                            <div class="col-xs-2">
                                <p class="badge pull-right" @click="toggleLike(input)">
                                    <span class="glyphicon glyphicon-thumbs-up" ></span>
                                    <span>{{input.like_counter?input.like_counter.count : 0 }} 赞 </span>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                {{input.name}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 ">
                                <small>
                                    <span class="text-muted">
                                        {{input.created_at}}
                                        <a href="/topic/{{input.topic_id}}/input/create">添加评论</a>

                                    </span>

                                </small>
                            </div>
                        </div>
                    </div>
                </div>




            </li>
        </ul>


    </div>

</template>



<script>

    export default {
        props:['list'],

        created() {
            this.list = JSON.parse(this.list);
        },

        data: function(){
            return {
                order: 'id',
                textStyleWords:'',
                textStyleLikes:'',
                textStyleId:'text-primary'
            }
        } ,

        computed: {

        },

        methods:{
            sortByWords(){
                this.order = this.orderByWords;
                this.textStyleWords = 'text-primary';
                this.textStyleId = '';
                this.textStyleLikes = '';
            },
            sortByLikes(){
                this.order = 'likeCount';
                this.textStyleWords = '';
                this.textStyleId = '';
                this.textStyleLikes = 'text-primary';
            },
            sortById(){
                this.order = 'id';
                this.textStyleWords = '';
                this.textStyleId = 'text-primary';
                this.textStyleLikes = '';
            },

            orderByWords: function(a,b) {
                return a.name.length - b.name.length;
            },
            toggleLike(input) {
                if(input.isLiked) {
                    this.unlike(input);
                }  else{
                    this.like(input);
                }
            },
            like(input){
                if (input.like_counter === null) {
                    input.like_counter = {};
                    input.like_counter.count = 0;
                }
                input.like_counter.count++;
                input.isLiked = !input.isLiked;
                this.storeLike(input);
            },

            unlike(input) {
                input.like_counter.count--;
                input.isLiked = !input.isLiked;
                this.storeUnlike(input);
            },

            storeLike(input){
                // GET /someUrl
                this.$http.get('/input/'+ input.id +'/like').then((response) => {
                    console.log(response);
                    // success callback
                }, (response) => {
                    // error callback
                    input.isLiked = false;
                });
            },

            storeUnlike(input) {
                this.$http.get('/input/' + input.id + '/unlike').then(
                        (response) =>{
                    console.log(response);
                }   ,(response) => {
                    input.isLiked = true;
                }
                );
            }
        }
    }

</script>