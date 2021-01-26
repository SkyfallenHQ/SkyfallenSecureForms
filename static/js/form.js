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
        var post_params = "csrf_id="+document.getElementsByName("csrf_id")[0].value+"&csrf_token="+document.getElementsByName("csrf_token")[0].value+"&form_id="+current_form_id+"&respondent_id="+respondentID+"&encryption_std="+encryption_standard;

        var publicKey = forge.pki.publicKeyFromPem(publicEncryptionKey);

        var key = forge.random.getBytesSync(32);
        var iv = forge.random.getBytesSync(16);

        if(encryption_standard == "RSA_PLUS_AES"){

            var iv_encrypted = publicKey.encrypt(iv, "RSA-OAEP", {
                md: forge.md.sha256.create(),
                mgf1: forge.mgf1.create()
            });

            var key_encrypted = publicKey.encrypt(key, "RSA-OAEP", {
                md: forge.md.sha256.create(),
                mgf1: forge.mgf1.create()
            });

            key_encrypted = forge.util.encode64(key_encrypted);
            iv_encrypted = forge.util.encode64(iv_encrypted);

            $("#aes_key").val(binarifiy(key_encrypted));
            $("#aes_iv").val(binarifiy(iv_encrypted));

            post_params = post_params+"&aes_key="+$("#aes_key").val()+"&aes_iv="+$("#aes_iv").val();

        }

        $(".formfield").each(function (index,obj) {

            var encodedEncryptedInput = "";

            switch (encryption_standard) {
                case "RSA_ONLY":
                    publicKey = forge.pki.publicKeyFromPem(publicEncryptionKey);

                    var userPlainInput = forge.util.encodeUtf8(obj.value);

                    var encryptedInput = publicKey.encrypt(userPlainInput, "RSA-OAEP", {
                        md: forge.md.sha256.create(),
                        mgf1: forge.mgf1.create()
                    });
                    encodedEncryptedInput = forge.util.encode64(encryptedInput);
                    break;

                case "RSA_PLUS_AES":

                    var cipher = forge.aes.createEncryptionCipher(key, 'CBC');
                    cipher.start(iv);
                    cipher.update(forge.util.createBuffer(obj.value));
                    cipher.finish();
                    var encrypted = cipher.output;

                    encodedEncryptedInput = forge.util.encode64(encrypted.getBytes());
                    break;

                case "DISABLED":
                    encodedEncryptedInput = obj.value;
            }

            post_params = post_params + "&field_"+index.toString()+"="+binarifiy(encodedEncryptedInput);

        })

        xhttp.send(post_params);

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $(document).ready(function () {
                    document.getElementById("responded").style.display = "flex";
                    document.getElementById("responded").scrollIntoView(true);
                    document.getElementsByClassName("form-wrapper")[1].style.display = "none";
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

function read_Disclaimer(){

    document.getElementById("form-disclaimer").style.display = "none";
    document.getElementById("form-wrapper").style.display = "block";

}