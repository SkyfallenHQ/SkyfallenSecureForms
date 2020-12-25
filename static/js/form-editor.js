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

function preparePreviousField(field_id){

    $(".editor-wrapper").sortable({
        revert: false,
        containment: 'parent',
    });

    $(".field-container").draggable({
        connectToSortable: ".editor-wrapper",
        helper: "self",
        revert: "invalid",
        containment: 'parent',
    });

    $(function(ready) {
        $("#"+field_id + "-labelset").change(function() {
            $("#"+field_id+"-previewlabel").text($("#"+field_id + "-labelset").val());
        });

        $("#"+field_id + "-typeselect").change(function() {
            switch ($("#"+field_id + "-typeselect").val()) {
                case "textinput":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-dropdown-objects-label").remove();
                    $("#"+field_id+"-previewinput").replaceWith("<input class=\"std-textinput\" type=\"text\" id=\""+field_id+"-previewinput"+"\">");
                    break;

                case "dropdown":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-dropdown-objects-label").remove();
                    $("#"+field_id+"-labelselector").append("<label for='"+field_id+"-dropdown-objects"+"' id='"+field_id+"-dropdown-objects-label"+"' class='std-label' style='color: white;'>Dropdown Options:</label><textarea class=\"std-textarea\" style=\"width: 550px; height: 100px; resize: none;\" placeholder='Seperated by a line break' id='"+field_id+"-dropdown-objects"+"'></textarea>");
                    $("#"+field_id+"-previewinput").replaceWith("<select class=\"std-select\" id=\""+field_id+"-previewinput"+"\"></select>");

                    $("#"+field_id + "-dropdown-objects").change(function() {
                        var dropdown_objects = $("#"+field_id + "-dropdown-objects").val().split("\n");

                        var select_html = "<select class=\"std-select\" id=\""+field_id+"-previewinput"+"\">";

                        dropdown_objects.forEach(function (item,index) {

                            select_html = select_html + "<option value='"+index+"'>"+item+"</option>";

                        });

                        select_html = select_html+"</select>";

                        $("#"+field_id+"-previewinput").replaceWith(select_html);

                    });
                    break;

                case "textarea":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-dropdown-objects-label").remove();
                    $("#"+field_id+"-previewinput").replaceWith("<textarea class=\"std-textarea\" type=\"text\" id=\""+field_id+"-previewinput"+"\"></textarea>");
                    break;
            }
        });
    });

}

function add_new_field(){

    var field_id = makeid(25);

    $(".editor-wrapper").append(" <div class=\"field-container\" id='"+field_id+"'>\n" +
        "                <div class=\"field-label-selector\" id='"+field_id+"-labelselector"+"'>\n" +
        "                    <label for=\""+field_id+"-labelset"+"\" class=\"std-label field-label-domlabel\">Field Label:</label>\n" +
        "                    <input class=\"std-textinput field-label-input\" type=\"text\" id=\""+field_id+"-labelset"+"\" placeholder=\"Field Label\">\n" +
        "                    <select class=\"std-select field-type-select\" id=\""+field_id+"-typeselect"+"\">\n" +
        "                        <option value='textinput' selected>Text Input</option>\n" +
        "                        <option value='textarea'>Textarea</option>\n" +
        "                        <option value='dropdown'>Dropdown</option>\n" +
        "                    </select>\n" +
        "                </div>\n" +
        "                <p class=\"preview-label-explanation\">Preview: <button class='trash-field' onclick=\"deleteField('"+field_id+"')\"><i class='fa fa-trash'></i></button></p>\n" +
        "                <hr>\n" +
        "                <div class=\"field-preview-selector\">\n" +
        "                    <label id=\""+field_id+"-previewlabel"+"\" for=\""+field_id+"-previewinput"+"\" class=\"std-label\">Field Label:</label>\n" +
        "                    <input class=\"std-textinput\" type=\"text\" id=\""+field_id+"-previewinput"+"\">\n" +
        "                </div>\n" +
        "            </div>");

    $(".editor-wrapper").sortable({
        revert: false,
        containment: 'parent',
    });

    $(".field-container").draggable({
        connectToSortable: ".editor-wrapper",
        helper: "self",
        revert: "invalid",
        containment: 'parent',
    });

    $(function(ready) {
        $("#"+field_id + "-labelset").change(function() {
            $("#"+field_id+"-previewlabel").text($("#"+field_id + "-labelset").val());
        });

        $("#"+field_id + "-typeselect").change(function() {
            switch ($("#"+field_id + "-typeselect").val()) {
                case "textinput":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-dropdown-objects-label").remove();
                    $("#"+field_id+"-previewinput").replaceWith("<input class=\"std-textinput\" type=\"text\" id=\""+field_id+"-previewinput"+"\">");
                    break;

                case "dropdown":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-dropdown-objects-label").remove();
                    $("#"+field_id+"-labelselector").append("<label for='"+field_id+"-dropdown-objects"+"' id='"+field_id+"-dropdown-objects-label"+"' class='std-label' style='color: white;'>Dropdown Options:</label><textarea class=\"std-textarea\" style=\"width: 550px; height: 100px; resize: none;\" placeholder='Seperated by a line break' id='"+field_id+"-dropdown-objects"+"'></textarea>");
                    $("#"+field_id+"-previewinput").replaceWith("<select class=\"std-select\" id=\""+field_id+"-previewinput"+"\"></select>");

                    $("#"+field_id + "-dropdown-objects").change(function() {
                       var dropdown_objects = $("#"+field_id + "-dropdown-objects").val().split("\n");

                       var select_html = "<select class=\"std-select\" id=\""+field_id+"-previewinput"+"\">";

                       dropdown_objects.forEach(function (item,index) {

                           select_html = select_html + "<option value='"+index+"'>"+item+"</option>";

                       });

                       select_html = select_html+"</select>";

                        $("#"+field_id+"-previewinput").replaceWith(select_html);

                    });
                    break;

                case "textarea":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-dropdown-objects-label").remove();
                    $("#"+field_id+"-previewinput").replaceWith("<textarea class=\"std-textarea\" type=\"text\" id=\""+field_id+"-previewinput"+"\"></textarea>");
                    break;
            }
        });
    });
}

function saveForm(){

    if(validateForm()){

        const Http = new XMLHttpRequest();
        const url=web_url+"jsapi/clearAllFields?form_id="+current_form_id;
        Http.open("GET", url);
        Http.send();

        Http.onreadystatechange = (e) => {

            if(Http.responseText == "{\"status\":\"OK\"}"){
                $('.field-container').each(function (field_pos, dom_obj){

                    var current_field_id = dom_obj.id;

                    var current_field_labelset = document.getElementById(current_field_id+"-labelset");

                    var field_label = current_field_labelset.value;

                    var current_field_options_table = document.getElementById(current_field_id+"-dropdown-objects");

                    var field_options = "";

                    if(current_field_options_table){

                        field_options = current_field_options_table.value;

                    }

                    var field_type = document.getElementById(current_field_id+"-typeselect").value;

                    const Http2 = new XMLHttpRequest();
                    const url= new URL(web_url+"jsapi/newField");
                    console.log(current_form_id);
                    url.searchParams.set('form_id',current_form_id);
                    url.searchParams.set('field_id',current_field_id);
                    url.searchParams.set('field_type', field_type);
                    url.searchParams.set('field_label', field_label);
                    url.searchParams.set('field_options', field_options);
                    url.searchParams.set('field_position', field_pos);
                    Http2.open("GET", url);
                    Http2.send();

                    Http2.onreadystatechange = (e) => {
                        if(Http2.responseText == "{\"status\":\"OK\"}"){
                            swal("Saved Successfully.");
                        }

                    };

                });

            }
        }

    } else {

        swal("You haven't filled all of the required information.");

    }

}

function validateForm() {

    var status = true;

    $('.field-container').each(function (index, dom_obj){

        var current_field_id = dom_obj.id;

        var current_field_labelset = document.getElementById(current_field_id+"-labelset");

        if(!current_field_labelset.value){

            status = false;

            return;
        }

        var current_field_options_table = document.getElementById(current_field_id+"-dropdown-objects");

        if(current_field_options_table){
            if(!current_field_options_table.value){

                status = false;

                return;

            }
        }

    });

    return status;
}

function deleteField(field_id){

    $("#"+field_id).remove();

}

function redirect_to_form_respond(){

    window.location.href = web_url+"form/"+current_form_id;

}