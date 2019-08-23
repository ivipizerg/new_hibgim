oxs_ckeditor_start = function(name,base){	
	
	var _this = this;

	this.b = CKEDITOR.replace(name,{
		baseHref : crypto_base64.D(base), 
		allowedContent : true,
		toolbarGroups : [
			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },			
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
			{ name: 'forms', groups: [ 'forms' ] },
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
			{ name: 'links', groups: [ 'links' ] },
			'/',
			{ name: 'insert', groups: [ 'insert' ] },
			{ name: 'styles', groups: [ 'styles' ] },
			{ name: 'colors', groups: [ 'colors' ] },
			{ name: 'tools', groups: [ 'tools' ] },
			'/',
			{ name: 'others', groups: [ 'others' ] },
			{ name: 'about', groups: [ 'about' ] }
		],
    
    	removeButtons : 'Styles,Format,Save,NewPage,Preview,Print,Templates,SelectAll,Find,Replace,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Blockquote,BidiLtr,BidiRtl,Language,Anchor,Flash,HorizontalRule,Smiley,Iframe,ShowBlocks,About'
	});	

	this.b.addCommand("isnertDoc", {
	  exec: function(editor) { 
	    aj_auth.Exec("files_manager",{ action: "get_form" , type: "doc_add_ckeditor" ,  page: 1 , search: null , name: name  } , function(Input){	    	
	    	jQuery(".oxs_main_container_dialog").html(Input.Msg); 	
	    });
	  }
	});

	this.b.ui.addButton("isnertDoc", {
	  label: "Прикрепить документ",
	  icon: "../../../../admin/tpl/default/img/Files-Download-File-icon.png",
	  command: "isnertDoc"
	});

	this.b.addCommand("isnertImg", {
	  exec: function(editor) { 
	    aj_auth.Exec("files_manager",{ action: "get_form" , type: "img_add_ckeditor" ,  page: 1 , search: null , name: name  } , function(Input){	    	
	    	jQuery(".oxs_main_container_dialog").html(Input.Msg); 	
	    });
	  }
	});

	this.b.ui.addButton("isnertImg", {
	  label: "Прикрепить изображение",
	  icon: "../../../../admin/tpl/default/img/add-picture.png",
	  command: "isnertImg"
	});

	

	this.updateSize = function(){
		
		try{
			var top = (jQuery("[name=" + name + "]").next().offset()).top;
		}catch(err){
			return ;
		}	

	    var pan = jQuery("[name=" + name + "]").next().find("#cke_1_top").outerHeight();
	    var edit_w = jQuery("[name=" + name + "]").next().outerHeight();
	    var wind = jQuery(window).outerHeight();
	    var bott = wind - ( edit_w  + top );	
	    setTimeout(function(){
	    	try{
	    		_this.b.resize( null , bott +  edit_w - 50) ;
	    	}catch(err){}	    		   
	    },10);	    
	}

	CKEDITOR.on( 'instanceReady', function( evt ) {	 
		_this.updateSize();	   
	} );	

	oxs_events.add(window,"resize",function(){	
		_this.updateSize();
	});

	this.des = function(){		
	}

	//	Обработка клика сохранить/добавить
	oxs_events.add(".oxs_active","mouseenter",function(){		
		ex_storage.add("textarea_edit",_this.b.getData(),1);
	});
}