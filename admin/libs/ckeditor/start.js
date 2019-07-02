oxs_ckeditor_start = function(name){	
	
	var _this = this;	

	var b = CKEDITOR.replace(name,{

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

	b.addCommand("isnertDoc", {
	  exec: function(editor) { 
	    aj_auth.Exec("files_manager",{ action: "get_form" , type: "doc_add" ,  page: 1 , search: null , name: name  } , function(Input){
	    	jQuery(".oxs_main_container_dialog").html(Input.Msg);
	    	console.log(Input);
	    	editor.insertHtml(Input.Msg);
	    });
	  }
	});

	b.ui.addButton("isnertDoc", {
	  label: "Прикрепить документ",
	  icon: "../../../../admin/tpl/default/img/Files-Download-File-icon.png",
	  command: "isnertDoc"
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
	    		b.resize( null , bott +  edit_w - 50) ;
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
}