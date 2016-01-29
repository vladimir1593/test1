BX.ready(function(){
	BX.bindDelegate(
		document.body, 'click', {className: 'like_btn' },
		function(e){
			var id=this.getAttribute('rel');
			var link=this.getAttribute('href');
			var self=this;
			BX.ajax.get(
				link,
				'id='+id,
				function(res){
					if(res==0){					
						self.innerHTML='Мне нравится статья';
					}
					if(res==1){
						self.innerHTML='Уже не нравится';
					}
				}
			);
				return BX.PreventDefault(e);
		}
	);
});