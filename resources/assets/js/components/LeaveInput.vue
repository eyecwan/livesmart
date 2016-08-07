<template>


    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <h2>{{topic.name}}</h2>
                    <form @submit.prevent="addInput">
                        <textarea class="form-control" rows="5"  placeholder="评论对所有人可见" v-model="new_input"></textarea>
                        <p></p>
                        <button type="submit" class="btn btn-success btn-lg btn-block">提交</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h3>我的评论：</h3>
        <div class="row">

            <ul class="list-group">
                <li class="list-group-item" v-for="input in topic.inputs | orderBy 'id' -1">

                    <div class="row">

                        <div class="col-xs-2">
                            <img :src="topic.user.avatar" class="img-responsive img-circle">

                        </div>
                        <div class="col-xs-10">
                            <p>
                                {{topic.user.name}}
                            </p>
                            <p>
                                {{input.name}}
                            </p>
                            <p>
                                <small class="text-muted">{{input.created_at}}</small>
                                <a @click="deleteTopic(input)"> <small>删除</small> </a>
                            </p>
                        </div>
                    </div>


                </li>
            </ul>
        </div>

    </div>






</template>

<script>


    export default {

        props:['topic'],

        data: function(){
            return {
                new_input:'',
                number: 99999
            };
        },

        created() {
            this.topic = JSON.parse(this.topic);

        },

        computed:{

        },

        methods:{

            addInput() {
                if (this.new_input.trim().length > 0 ){
                    length = this.topic.inputs.push({
                        name:this.new_input,
                        id: this.number++
                    });
                    var [matchedTags,type] = this.detectTag();
                    this.storeInput(length-1,matchedTags,type);
                    this.new_input ='';
                }

            },

            newInputContains(element) {
                return this.new_input.indexOf(element) > -1;
            },

            detectTag(){
                var wantedTags = [
                        '方太',
                        '西门子',
                        '博世',
                        '伊莱克斯',
                        '小米'
                ];

                var friendly = Math.random()*1.5 > 0.5 ? true:false;
                var friendlyConfirm = friendly? '挺满意的':'不满意';

                var matchedTags = wantedTags.filter(this.newInputContains);
                var type;
                if ( matchedTags.length > 0  ) {
                    if (confirm('语义分析判断认为你对' + matchedTags[0] + '的' + this.topic.name + friendlyConfirm + ',是吗？不是请按取消')) {
                        type = friendly;
                    } else {
                        type = ! friendly;
                    }
                }
                if (friendly) {
                    matchedTags.push('正面评价');
                } else {
                    matchedTags.push('方面评价');
                }
                console.log(matchedTags);
                return [matchedTags,type];

            },



            storeInput(removeIndex,matchedTags,friendly) {

                console.log(matchedTags);
                this.$http.post('/topic/' + this.topic.id + '/input',{
                    'name' : this.new_input,
                    'type' : friendly? 'postive' : 'negtive'
                }).then(
                        (response) => {
                    console.log(response);
                    this.topic.inputs.splice(removeIndex,1);
                    this.topic.inputs.push(response.json());
                    if(matchedTags.length>0) {
                        this.storeTags(response.json(),matchedTags.join());
                    }

                },(response) => {

                }

                );

            },

            deleteTopic(input){
                this.topic.inputs.$remove(input);
                this.destroyInput(input);
            },

            destroyInput(input){
                this.$http.delete('/input/' + input.id).then(function(response) {
                    console.log(response);
                },function(response) {

                });
            },

            storeTags(input, tags) {
                this.$http.post('/input/' + input.id + '/tag',{
                    'tags' : tags
                }).then(
                        (response)=>{
                    console.log(response);
                },(response) =>{

                }
                )
            }
        }
    }
</script>