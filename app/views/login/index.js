$("input[type='submit']").on('click',function (){
    $(".error_text").each(function() {
        if(!$(this).hasClass("hidden_text")){
            $(this).addClass("hidden_text")
        }
    })
    let num = $("input[name='number']").val()
    let pass = $("input[name='password']").val()
    if(num[0] == "0"){
            num = num.slice(1, num.length)
            $("input[name='number']").val(num)
        }
    $.ajax({
        url: "login/check_data",
        type: "POST",
        data: {
            "number": num,
            "password": pass,
        },
        success: function (response){
            response = JSON.parse(response);
            switch(response.code){
                case 0:
                    $("#password-box .error_text").text("*Wrong number or password.")
                    $("#password-box .error_text").removeClass("hidden_text")
                    break
                case 1:
                    location.reload()
                    break
            };
        },
        error: function (response) {
            alert("Server-side error.");
        }
    });
})
$("<div>",{text:"Made by Arian", css:{position:"absolute", bottom:"8px", left:"8px", fontSize:"0.8rem", color:"white"}}).appendTo("body");