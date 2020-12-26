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