var Vue = require("vue");
var request = require("superagent");

new Vue({
	el: "#main",
	data: {
		message: "init",
		text: "",
		items: []
	},
	methods: {
		fetchPosts: function(){
			var self = this;
			request
				.get("./api.php/items/")
				.end(function(err, res){
					self.items = res.body;
				})
		},
		createPost: function(text){
			var self = this;
			request
				.post("./api.php/items/")
				.type('form')
				.send({text: text})
				.end(function(err, res){
					if(err){
						console.error(err);
					}
					self.text = "";
					self.fetchPosts();
				});
		}
	},
	ready: function(){
		this.fetchPosts();
	}
})
