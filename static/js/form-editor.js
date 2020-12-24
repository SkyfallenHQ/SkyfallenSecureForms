function return_to_dashboard(){

    window.location.href = "../..";

}

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}


function add_new_field(){

    var field_id = makeid(25);

    $(".editor-wrapper").append(" <div class=\"field-container\">\n" +
        "                <div class=\"field-label-selector\">\n" +
        "                    <label for=\""+field_id+"-labelset"+"\" class=\"std-label field-label-domlabel\">Field Label:</label>\n" +
        "                    <input class=\"std-textinput field-label-input\" type=\"text\" id=\""+field_id+"-labelset"+"\" placeholder=\"Field Label\">\n" +
        "                    <select class=\"std-select field-type-select\" id=\""+field_id+"-typeselect"+"\">\n" +
        "                        <option selected>Text Input</option>\n" +
        "                        <option>Textarea</option>\n" +
        "                        <option>Dropdown</option>\n" +
        "                    </select>\n" +
        "                </div>\n" +
        "                <p class=\"preview-label-explanation\">Preview:</p>\n" +
        "                <hr>\n" +
        "                <div class=\"field-preview-selector\">\n" +
        "                    <label for=\""+field_id+"-previewlabel"+"\" class=\"std-label\">Preview Label:</label>\n" +
        "                    <input class=\"std-textinput\" type=\"text\" id=\""+field_id+"previewinput"+"\">\n" +
        "                </div>\n" +
        "            </div>");

    $(".editor-wrapper").sortable({
        revert: false
    });

    $(".field-container").draggable({
        connectToSortable: ".editor-wrapper",
        helper: "self",
        revert: "invalid",
        cancel: '.form-title-container',
    });
    $(function(ready) {
        $("#"+field_id + "-labelset").change(function() {

            alert("Value Changed");
            $("#"+field_id + "-previewlabel").text($("#"+field_id + "-labelset").value());

        });
    });

}