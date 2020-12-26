$(document).ready(function () {

    $(".form-wrapper").each(function (index,obj) {

        obj.style.display = "none";

    });

    document.getElementsByClassName("form-wrapper")[0].style.display = "initial";

    $("#response-select").change(function () {

        $(".form-wrapper").each(function (index,obj) {

            obj.style.display = "none";

        });

        document.getElementById($("#response-select").val()).style.display = "initial";
    });

})

function selectNext(){
    var select = document.getElementById('response-select');
    if(select.selectedIndex != select.childElementCount-1){
        select.selectedIndex++;
        $(".form-wrapper").each(function (index,obj) {

            obj.style.display = "none";

        });

        document.getElementById($("#response-select").val()).style.display = "initial";
    }
}

function selectPrev(){
    var select = document.getElementById('response-select');
    if(select.selectedIndex != 0){
        select.selectedIndex = select.selectedIndex - 1;
        $(".form-wrapper").each(function (index,obj) {

            obj.style.display = "none";

        });

        document.getElementById($("#response-select").val()).style.display = "initial";
    }
}