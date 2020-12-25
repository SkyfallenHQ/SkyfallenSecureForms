function validateFields(){

    var status = true;

    $(".formfield").each(function (index,obj) {

        if(!obj.value){

            status = false;

            return;
        }

    });

    return status;

}

function submitForm() {

    if(validateFields()){

        var encryptor = new JSEncrypt();

        encryptor.setPublicKey(publicEncryptionKey);

        console.log(publicEncryptionKey);

        var xhttp = new XMLHttpRequest();

        xhttp.open("POST", web_url+"respond", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var post_params = "csrf_id="+document.getElementsByName("csrf_id")[0].value+"&csrf_token="+document.getElementsByName("csrf_token")[0].value+"&form_id="+current_form_id+"&respondent_id="+respondentID;

        $(".formfield").each(function (index,obj) {

            console.log(encryptor.encrypt(obj.value));

            post_params = post_params + "&field_"+index.toString()+"="+encryptor.encrypt(obj.value);

        })

        xhttp.send(post_params);

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $(document).ready(function () {
                    document.getElementById("body-wrap").style.display = "none";
                    document.getElementById("responded").style.display = "initial";
                });
            }
        };

    } else {

        swal("Please fill out all required fields.");

    }

}