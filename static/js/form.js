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

        $(".formfield").each(function (index,obj) {

            if(!obj.value){

                status = false;

                return;
            }

        })

    } else {

        swal("Please fill out all required fields.");

    }

}