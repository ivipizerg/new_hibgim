oxs_tinymce_tinymce_start = function(name){
	
	console.log("Хуй");

	ClassicEditor
        .create( document.querySelector( "[name=" + name + "]" ) , {

        	toolbar: [ 'heading', '|', 'bold', 'italic', '|' ,'link', 'bulletedList', 'numberedList', 'blockQuote' , 'code' ]
            
            /*heading: {
	            options: [
	                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
	                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
	                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
	            ]
        	}*/

        } )
        .catch( error => {
            console.error( error );
        } );
}