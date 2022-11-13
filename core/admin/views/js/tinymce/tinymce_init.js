

// function MCEInit(element, height = 400) {
//
//     tinymce.init({
//         language: 'en',
//         mode: 'exact',
//         elements: element,
//         height: height,
//         relative_urls: false,
//
//     })
//
// }

function MCEInit(element, height = 400) {

    tinymce.init({
        language: 'en',
        mode: 'exact',
        elements: element,
        height: height,
        gecko_spellcheck: true,
        relative_urls: false,
        setup : function(editor) {
            editor.on("change keyup", function(e){
                console.log('saving');
                //tinyMCE.triggerSave(); // updates all instances
                editor.save(); // updates this instance's textarea
            });

        }

    })

}


let elements = document.querySelector('.tinymce-editor');



MCEInit(elements.getAttribute('name'));
