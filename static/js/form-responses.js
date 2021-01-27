$(document).ready(function () {

    $(".form-wrapper").each(function (index,obj) {

        obj.style.display = "none";

    });

    document.getElementsByClassName("form-wrapper")[0].style.display = "block";

    $("#response-select").change(function () {

        $(".form-wrapper").each(function (index,obj) {

            obj.style.display = "none";

        });

        document.getElementById($("#response-select").val()).style.display = "block";
    });

})

function selectNext(){
    var select = document.getElementById('response-select');
    if(select.selectedIndex != select.childElementCount-1){
        select.selectedIndex++;
        $(".form-wrapper").each(function (index,obj) {

            obj.style.display = "none";

        });

        document.getElementById($("#response-select").val()).style.display = "block";
    }
}

function selectPrev(){
    var select = document.getElementById('response-select');
    if(select.selectedIndex != 0){
        select.selectedIndex = select.selectedIndex - 1;
        $(".form-wrapper").each(function (index,obj) {

            obj.style.display = "none";

        });

        document.getElementById($("#response-select").val()).style.display = "block";
    }
}

function deleteResponse(){

    swal({
        title: "Are you sure you want to delete this response?",
        text: "Once deleted, you will not be able to recover it!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var respondent_id = $("#response-select").val()
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", web_url+"jsapi/deleteResponse", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var post_params = "form_id="+current_form_id+"&respondent_id="+respondent_id;

                xhttp.send(post_params);

                xhttp.onreadystatechange = (e) => {

                    if(xhttp.responseText == "{\"status\":\"OK\"}"){
                        swal("Success!", "We have successfully deleted this response")
                        selectNext()
                        $("#response-select option[value='"+respondent_id+"']").remove();
                        $("#"+respondent_id).remove()
                    } else {
                        swal("Error", xhttp.responseText)
                    }

                }

            } else {
                swal("The request has been cancelled.");
            }
        });



}

function exportExcel(){

    if(document.getElementsByClassName("exporting-notification")[0].style.display == "none"){

        document.getElementsByClassName("exporting-notification")[0].style.display = "block";

        const dl_a = document.createElement("a");
        dl_a.style.display = "none";
        document.body.appendChild(dl_a);

        dl_a.href = web_url+"forms/exportResponses/"+current_form_id
        dl_a.target = "_blank";

        dl_a.click();

        window.URL.revokeObjectURL(dl_a.href);
        document.body.removeChild(dl_a);

        document.getElementsByClassName("exporting-notification")[0].style.display = "none";

    } else {

        swal({
            title: "Error",
            text: "An export query is currently being executed.",
            icon: "error"
        })

    }

}