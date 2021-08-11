<?php
/** @var $this yii\web\View */

/* @var User $user */

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Chats';
$thisUser = $this->user;
?>
<div class="row" style="height: 600px" id="chat">
    <div class="col-md-4 col-xs-12" style="background: white;height: 100%;padding:20px;">
        <?php
        $form = ActiveForm::begin(
            [
                'action' => Url::to(['site/create-chat-box']),
                'method' => 'get',
                'options' => [
                    'class' => 'form-inline',
                    'role' => 'form',
                    'style' => 'display:flex;flex-direction: row;',
                ],
            ]);
        ?>
        <div class="form-group" style="flex-grow: 1;">
            <label class="sr-only" for="">label</label>
            <input type="email" class="form-control" name="email" style="width: 100%;" id=""
                placeholder="Enter email...">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <?php ActiveForm::end(); ?>
        <div class="form-group has-feedback has-search" style="margin-top: 10px">
            <span class="glyphicon glyphicon-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
        <div>
            <?php foreach ($chatBoxs as $model): ?>
            <div class="list-group">
                <a href="#" class="list-group-item" @click="getActive('<?=$model->theirOne->username; ?>',<?=$model->theirOne->id; ?>,<?=$model->id; ?>)"
                    :class="{active:active == '<?=$model->theirOne->username; ?>'}">
                    <h4 class="list-group-item-heading"><?=$model->theirOne->username; ?></h4>
                    <p class="list-group-item-text"><?=$model->theirOne->email; ?></p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="panel panel-default" style="display: flex;flex-direction: column;height: 600px">
            <div class="panel-heading">
                <h3 class="panel-title"><b>{{active}}</b></h3>
            </div>
            <div class="panel-body" style="flex-grow: 1;overflow: auto;">
                <div v-for="message in list_messages">
                    <div class="direct-chat-msg left" v-if="message.user_id != <?=$thisUser->id; ?>">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left">{{message.emailSend}}</span>
                            <span class="direct-chat-timestamp pull-right">23 Jan 2:05 pm</span>
                        </div>
                        <img class="direct-chat-img" src="https://bootdey.com/img/Content/user_2.jpg"
                            alt="Message User Image">
                        <div class="direct-chat-text">
                            {{message.content}}
                        </div>
                    </div>

                    <div class="direct-chat-msg right" v-else>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right"><?=$thisUser->username; ?></span>
                                <span class="direct-chat-timestamp pull-left">23 Jan 2:00 pm</span>
                            </div>
                            <img class="direct-chat-img" src="https://bootdey.com/img/Content/user_1.jpg"
                                alt="Message User Image">
                            <div class="direct-chat-text" style="background: #7bff85;">
                                {{message.content}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control"
                        v-model="content" @keyup.enter="sendMessage()">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" @click="sendMessage()">Send</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<<JS
const socket = io("ws://localhost:3000");
var api = 'http://chat-example.demo/index.php?r=site/get-message&chat_box_id=';
var userRegister = {
	id:$thisUser->id,
	username:"$thisUser->username",
	email:"$thisUser->email",
}
console.log(userRegister)
socket.emit('register',userRegister);
var app = new Vue({
  el: '#chat',
  data: {
	user_send:"",
    active:"MESSAGE BOX",
	content:"",
	list_messages:[],
    chat_box_id:'',

  },
  mounted:function(){
        socket.on("server-send-client",(data)=>{
            console.log(data);
            if(data !== undefined && data.chat_box == this.chat_box_id){
                this.list_messages.push(data);
            }
            console.log(this.list_messages);
        });
    },
  methods:{
	getActive: function(username,id,chat_box_id) {
		this.active = username;
		this.user_send = id;
        this.chat_box_id = chat_box_id;
        let  list_messages = [];
        axios.get(api+this.chat_box_id)
        .then((response) => {
            // this.list_messages = JSON.parse(response.data)
            // this.list_messages = getMessage(response.data);
            response.data.forEach(function (element) {
                let item = JSON.parse(element);
                list_messages.push(item);
            });
        });
        this.list_messages = list_messages;
	},
	sendMessage:function(){
		if(this.user_send == ''){ alert("Chua chon user"); return false;}
		if(this.content  == ""){return false}
		let message = {
				type:"personal",
				content: this.content,
				user_id: $thisUser->id,
				user_send:this.user_send,
                chat_box:this.chat_box_id,
			};
		this.list_messages.push(message);
		socket.emit('send-message',message);
		this.content="";
	},
  }
})

function getMessage(data){
    var list = [];
    data.forEach(function (element) {
        list.push(element)
    });
    return list
}
JS;
$this->registerJs($js, View::POS_END);
?>