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
        axis: "y",
        stop: function() {
            return $(this).css({
                height: 'auto'
            });
        },
    });

    if($("#"+field_id + "-typeselect").val() == "dropdown"){

        $("#"+field_id + "-dropdown-objects").change(function() {
            var dropdown_objects = $("#"+field_id + "-dropdown-objects").val().split("\n");

            var select_html = "<select class=\"std-select\" id=\""+field_id+"-previewinput"+"\">";

            dropdown_objects.forEach(function (item,index) {

                select_html = select_html + "<option value='"+index+"'>"+item+"</option>";

            });

            select_html = select_html+"</select>";

            $("#"+field_id+"-previewinput").replaceWith(select_html);

        });

    }

    $(function(ready) {
        $("#"+field_id + "-labelset").change(function() {
            $("#"+field_id+"-previewlabel").text($("#"+field_id + "-labelset").val());
        });

        $("#"+field_id + "-typeselect").change(function() {
            switch ($("#"+field_id + "-typeselect").val()) {
                case "textinput":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-previewinput").replaceWith("<input class=\"std-textinput\" type=\"text\" id=\""+field_id+"-previewinput"+"\">");
                    break;

                case "dropdown":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-bottomwrap").append("<textarea class=\"std-textarea form-drop-objs\" placeholder='Dropdown Objects, Separated by a line break' id='"+field_id+"-dropdown-objects"+"'></textarea>");
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
                    $("#"+field_id+"-previewinput").replaceWith("<textarea class=\"std-textarea\" type=\"text\" id=\""+field_id+"-previewinput"+"\"></textarea>");
                    break;
            }
            if(document.getElementById(field_id+"-bottomwrap").hasChildNodes()){
                document.getElementById(field_id+"-bottomwrap").style.display = "block";
            } else {
                document.getElementById(field_id+"-bottomwrap").style.display = "none";
            }
        });
        $("#"+field_id+"-isrequired").change(function() {
            if(this.checked) {
                var fieldElement = document.getElementById(field_id+"-previewlabel");
                fieldElement.classList.add("required-label");
            }else{
                var fieldElement = document.getElementById(field_id+"-previewlabel");
                fieldElement.classList.remove("required-label");
            }
        });
    });

}

function add_new_field(){

    var field_id = makeid(25);

    $(".editor-wrapper").append("<div class=\"field-wrap\" id=\""+field_id+"\" onclick=\"swapEditPreview(event,'"+field_id+"')\">\n" +
        "                                <div class=\"field-top-wrap\" id=\""+field_id+"-topwrap\">\n" +
        "                                    <select class=\"std-select field-type-select-alt\" id='"+field_id+"-typeselect'>\n" +
        "                                        <option value='textinput' selected>Text Input</option>\n" +
        "                                        <option value='textarea'>Textarea</option>\n" +
        "                                        <option value='dropdown'>Dropdown</option>\n" +
        "                                    </select>\n" +
        "                                    <label class=\"std-checkbox-container floatright\">\n" +
        "                                        Mark this field as required\n" +
        "                                        <input type=\"checkbox\" id=\""+field_id+"-isrequired\" class=\"std-checkbox\">\n" +
        "                                        <span class=\"checkmark\"></span>\n" +
        "                                    </label>\n" +
        "                                    <button class='trash-field' onclick=\"deleteField('"+field_id+"')\"><i class='fa fa-trash'></i></button>\n" +
        "                                </div>\n" +
        "\n" +
        "                                <div class=\"field-preview-wrap\" id=\""+field_id+"-previewwrap\">\n" +
        "                                    <input class=\"std-textinput field-label-input field-labelset\" type=\"text\" id='"+field_id+"-labelset' placeholder=\"Field Label\">\n" +
        "                                    <label id='"+field_id+"-previewlabel' for='"+field_id+"-previewinput' class=\"std-label\" style=\"display: none;\"></label>\n" +
        "                                    <input class=\"std-textinput\" type=\"text\" id=\""+field_id+"-previewinput\">\n" +
        "                                </div>\n" +
        "                                <div class=\"field-bottom-wrap\" id=\""+field_id+"-bottomwrap\"></div>\n" +
        "                            </div>");

    $(".editor-wrapper").sortable({
        revert: false,
        containment: 'parent',
    });

    $(".field-container").draggable({
        connectToSortable: ".editor-wrapper",
        helper: "self",
        revert: "invalid",
        containment: 'parent',
        stop: function() {
            return $(this).css({
                height: 'auto'
            });
        },
    });

    $(function(ready) {

        $(".field-wrap").each( function (index,elm) {

            if (document.getElementById(elm.id + "-topwrap").style.display == "block") {

                document.getElementById(elm.id + "-bottomwrap").style.display = "none";
                document.getElementById(elm.id + "-topwrap").style.display = "none";
                var fieldElement = document.getElementById(elm.id);
                fieldElement.classList.remove("focused");
                document.getElementById(elm.id + "-labelset").style.display = "none";
                document.getElementById(elm.id + "-previewlabel").style.display = "block";

            }
        });

        document.getElementById(field_id+"-topwrap").style.display = "block";
        if(document.getElementById(field_id+"-bottomwrap").hasChildNodes()){
            document.getElementById(field_id+"-bottomwrap").style.display = "block";
        } else {
            document.getElementById(field_id+"-bottomwrap").style.display = "none";
        }
        var fieldElement = document.getElementById(field_id);
        fieldElement.classList.add("focused");
        document.getElementById(field_id+"-previewlabel").style.display = "none";
        document.getElementById(field_id+"-labelset").style.display = "block";

        $("#"+field_id + "-labelset").change(function() {
            $("#"+field_id+"-previewlabel").text($("#"+field_id + "-labelset").val());
        });

        $("#"+field_id + "-typeselect").change(function() {
            switch ($("#"+field_id + "-typeselect").val()) {
                case "textinput":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-previewinput").replaceWith("<input class=\"std-textinput\" type=\"text\" id=\""+field_id+"-previewinput"+"\">");
                    break;

                case "dropdown":
                    $("#"+field_id+"-dropdown-objects").remove();
                    $("#"+field_id+"-bottomwrap").append("<textarea class=\"std-textarea form-drop-objs\" placeholder='Dropdown Objects, Separated by a line break' id='"+field_id+"-dropdown-objects"+"'></textarea>");
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
                    $("#"+field_id+"-previewinput").replaceWith("<textarea class=\"std-textarea\" type=\"text\" id=\""+field_id+"-previewinput"+"\"></textarea>");
                    break;
            }
            if(document.getElementById(field_id+"-bottomwrap").hasChildNodes()){
                document.getElementById(field_id+"-bottomwrap").style.display = "block";
            } else {
                document.getElementById(field_id+"-bottomwrap").style.display = "none";
            }
        });
        $("#"+field_id+"-isrequired").change(function() {
            if(this.checked) {
                var fieldElement = document.getElementById(field_id+"-previewlabel");
                fieldElement.classList.add("required-label");
            }else{
                var fieldElement = document.getElementById(field_id+"-previewlabel");
                fieldElement.classList.remove("required-label");
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
            console.log("Clearing Fields:"+Http.responseText);

            if(Http.responseText == "{\"status\":\"OK\"}"){

                $('.field-wrap').each(function (field_pos, dom_obj){
                    console.log("Iterating Fields:"+field_pos);
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
                    url.searchParams.set('is_required', $("#"+current_field_id+"-isrequired").is(':checked'));
                    Http2.open("GET", url);
                    console.log("Sending a new field to the API:"+url.searchParams.toString());
                    Http2.send();

                    Http2.onreadystatechange = (e) => {
                        console.log("API RESPONSE RECEIVED:"+Http2.responseText);
                        if(Http2.responseText.includes("{\"status\":\"OK\"}")){
                            saveFormDescription()
                            swal("Saved Successfully.");
                        }

                    };

                });

            }
        }

    } else {

        swal("Some fields don't have a label.");

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

function redirect_to_form_responses(){

    window.location.href = web_url+"forms/responses/"+current_form_id;

}

function showSettingsModal(){

    if($(window).width()>799) {

        $(".settings-modal")[0].style.display = "block";
        $(".bgblurred")[0].style.display = "block";

        switchToModalTab('general');

    } else {

        swal("We can't display the settings on this display.");

    }

}

function closeSettingsModal(){

    $(".settings-modal")[0].style.display = "none";
    $(".bgblurred")[0].style.display = "none";
    document.body.style.pointerEvents = "initial";

}

function switchToModalTab(modal_tab_name) {


        $(".modal-tab-each").each((index, object) => {

            object.style.display = "none";

        });

        $(".modal-tab-button").each((index, object) => {

            object.style.background = "#f8f6f6";

        });

        document.getElementById("modal-tab-btn-" + modal_tab_name).style.background = "#e2d9d9";

        document.getElementById("modal-tab-" + modal_tab_name).style.display = "inline-block";

}


function save_General_Settings(){

    const Http = new XMLHttpRequest();
    const url=web_url+"jsapi/setFormName?form_id="+current_form_id+"&new_name="+$("#settings_form_name").val();
    Http.open("GET", url);
    Http.send();

    Http.onreadystatechange = (e) => {
        if(Http.status == 200){
            $("#form-title-hdg").text($("#settings_form_name").val());
        }
    };

    var xhttp = new XMLHttpRequest();

    xhttp.open("POST", web_url+"jsapi/setFormDisclaimer", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var post_params = "form_id="+current_form_id+"&new_disclaimer="+$("#form-disclaimer-setting").val();

    xhttp.send(post_params);

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", web_url+"jsapi/setFormStyle", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var post_params = "form_id="+current_form_id+"&new_style="+$("#style-select").val();

    xhttp.send(post_params);

    xhttp.onreadystatechange = (e) => {
        console.log(xhttp.response)
    };

}

function save_Enc_Std(){


    const Http = new XMLHttpRequest();
    const url=web_url+"jsapi/setEncryptionStandard?form_id="+current_form_id+"&newStandard="+$("#encryption-select").val();
    Http.open("GET", url);
    Http.send();

}

function saveFormDescription(){

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", web_url+"jsapi/setFormDescription", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var post_params = "form_id="+current_form_id+"&new_description="+$("#form-description-setting").val();

    xhttp.send(post_params);

}

function swapEditPreview(event,field_id){

    var elm = event.target;

    if (elm.id === field_id+"-labelset" || elm.id === field_id+"-previewinput" || elm.id === field_id+"-topwrap" || elm.id === field_id+"-typeselect" || elm.id === field_id+"-dropdown-objects") {
        return;
    }

    if(document.getElementById(field_id+"-topwrap").style.display == "block"){

        document.getElementById(field_id+"-bottomwrap").style.display = "none";
        document.getElementById(field_id+"-topwrap").style.display = "none";
        var fieldElement = document.getElementById(field_id);
        fieldElement.classList.remove("focused");
        document.getElementById(field_id+"-labelset").style.display = "none";
        document.getElementById(field_id+"-previewlabel").style.display = "block";

    } else {

        $(".field-wrap").each( function (index,elm) {

            if(document.getElementById(elm.id+"-topwrap").style.display == "block") {

                document.getElementById(elm.id+"-bottomwrap").style.display = "none";
                document.getElementById(elm.id+"-topwrap").style.display = "none";
                var fieldElement = document.getElementById(elm.id);
                fieldElement.classList.remove("focused");
                document.getElementById(elm.id+"-labelset").style.display = "none";
                document.getElementById(elm.id+"-previewlabel").style.display = "block";

            }

        })


        document.getElementById(field_id+"-topwrap").style.display = "block";
        if(document.getElementById(field_id+"-bottomwrap").hasChildNodes()){
            document.getElementById(field_id+"-bottomwrap").style.display = "block";
        } else {
            document.getElementById(field_id+"-bottomwrap").style.display = "none";
        }
        var fieldElement = document.getElementById(field_id);
        fieldElement.classList.add("focused");
        document.getElementById(field_id+"-previewlabel").style.display = "none";
        document.getElementById(field_id+"-labelset").style.display = "block";

    }

}

function fieldDoubleInitialise(field_id){

    document.getElementById(field_id + "-bottomwrap").style.display = "none";
    document.getElementById(field_id+"-topwrap").style.display = "none";
    var fieldElement = document.getElementById(field_id);
    fieldElement.classList.remove("focused");
    document.getElementById(field_id+"-labelset").style.display = "none";
    document.getElementById(field_id+"-previewlabel").style.display = "block";

}

function toggleDescription(event) {

    var elm = event.target;

    if (elm.id === "form-description-setting") {
        return;
    }

    if(document.getElementById("form-description-setting").style.display == "block"){

        document.getElementById("form-description-setting").style.display = "none";

    } else {

        document.getElementById("form-description-setting").style.display = "block";

    }

}