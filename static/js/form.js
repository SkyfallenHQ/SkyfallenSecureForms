function validateFields(){

    var status = true;

    $(".required-field").each(function (index,obj) {

        if(!obj.value){

            status = false;

            return;
        }

    });

    return status;

}

function submitForm() {

    if(validateFields()){

        var xhttp = new XMLHttpRequest();

        xhttp.open("POST", web_url+"respond", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var post_params = "csrf_id="+document.getElementsByName("csrf_id")[0].value+"&csrf_token="+document.getElementsByName("csrf_token")[0].value+"&form_id="+current_form_id+"&respondent_id="+respondentID;

        $(".formfield").each(function (index,obj) {

            var publicKey = forge.pki.publicKeyFromPem(publicEncryptionKey);

            var userPlainInput = forge.util.encodeUtf8(obj.value);

            var encryptedInput = publicKey.encrypt(userPlainInput, "RSA-OAEP", {
                md: forge.md.sha256.create(),
                mgf1: forge.mgf1.create()
            });
            var encodedEncryptedInput = forge.util.encode64(encryptedInput);

            console.log(binarifiy(encodedEncryptedInput));

            post_params = post_params + "&field_"+index.toString()+"="+binarifiy(encodedEncryptedInput);

        })

        xhttp.send(post_params);

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $(document).ready(function () {
                    document.getElementsByClassName("form-wrapper")[0].style.display = "none";
                    document.getElementsByClassName("form-title-container")[0].style.display = "none";
                    document.getElementById("responded").style.display = "flex";
                });
            }
        };

    } else {

        swal("Please fill out all required fields.");

    }

}

function binarifiy(input) {
    var output = ""
    for (var i = 0; i < input.length; i++) {
        output += input[i].charCodeAt(0).toString(2) + " ";
    }
    return output;
}