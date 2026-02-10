<script src="{{asset('assets/dashboard/plugins')}}/editor/ckeditor/ckeditor.js"></script>
<script src="{{asset('assets/dashboard/plugins')}}/editor/ckeditor/adapters/jquery.js"></script>
<script src="{{asset('assets/dashboard/plugins')}}/editor/ckeditor/styles.js"></script>
<script src="{{asset('assets/dashboard/plugins')}}/editor/ckeditor/ckeditor.custom.js"></script>


<script>
const fullEditorConfig = {
            toolbar: [
                {name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
                {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
                {name: 'forms', items: ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField']},
                '/', {name:'basicstyles', items:['Bold','Italic','Underline','Strike','Subscript','Superscript','-','CopyFormatting','RemoveFormat']},
                {name:'paragraph', items:['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl']},
                {name:'links', items:['Link','Unlink','Anchor']},
                {name:'insert', items:['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe', 'uploadImage', 'insertTable']},
                '/', {name:'styles', items:['Styles','Format','Font','FontSize']},
                {name:'colors', items:['TextColor','BGColor']},
                {name:'tools', items:['Maximize','ShowBlocks']},
                {name:'about', items:['About']}
            ],
            height:300,
            removePlugins:'elementspath',
            resize_enabled:true,
            extraPlugins:'colorbutton,font,justify,print,preview,flash,smiley,pagebreak,iframe',
            filebrowserUploadUrl:"",
            filebrowserUploadMethod:'form',
            shouldNotGroupWhenFull: true
        };

        if(document.getElementById('content')) CKEDITOR.replace('content', fullEditorConfig);
        if(document.getElementById('content_bn')) CKEDITOR.replace('content_bn', fullEditorConfig);
</script>
