<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app\views\index\css\style.css">
    <title>Messenger</title>
</head>
<body onload="refresh_contacts()">
    <div class="main-wrapper">
        <div class="main-container">
            <div class="messenger-container">

            </div>
            <div class="contact-wrapper">
                <div class="contact-control">
                    <button title="Add contact" class="add-contact-btn" type="button">+</button>
                    <button title="Edit mode" class="edit-contact-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg></button>
                    <form onsubmit="return false;" class="contact-actions-modal hidden">
                        <div class="hidden">
                            <p class="modal-info">Add Contact</p>
                            <div class="add-contact-name">
                                <input type="text" placeholder="Contact name">
                                <p class="error-text hidden">*</p>
                            </div>
                            <div class="add-contact-number">
                                <input type="tel" placeholder="Contact number">
                                <p class="error-text hidden">*</p>
                            </div>
                            <input type="submit" value="Confirm" class="create-contact-btn">
                        </div>
                    </form>
                </div>
                <div class="contacts-container">
                    <div class="contact-card hidden">
                        <img class="contact-photo" src="app\views\index\css\user-icon.webp" alt="">
                        <div class="message-wrapper">
                            <p class="contact-name">test</p>
                            <p class="contact-last-message">test</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/jquery-3.4.1.min.js"></script>

    <script>
        let edit_mode = false
        let contacts;
        { // loading actions/refreshing contacts
            // refreshing contacts
            let card;
            function refresh_contacts(){
                card = $(".contact-card").clone(true)
                card.removeClass("hidden")
                $(".contacts-container").empty()
                $.ajax({
                    url: "index/get_contacts",
                    type: "POST",
                    // data: {
                    //     "name" : name,
                    //     "number" : num
                    // },
                    success: function (response){
                        response = JSON.parse(response);
                        contacts = response
                        for(let [val, i] of response.entries()){
                            let new_card = card.clone(true)
                            new_card.appendTo(".contacts-container")
                            let info = new_card.children(".message-wrapper")
                            info.children(".contact-name").text(i["name"])
                            info.children(".contact-last-message").text("...").css("font-size", "1.3rem")
                            
                        };
                    },
                    error: function (response) {
                        alert("Server-side error.");
                    }
                });
            }
        }
        { // contact actions
            { // modals
                // opening the add contact modal
                $(".add-contact-btn").on('click',function (){
                    let modal = $(".contact-actions-modal")
                    let delay = 0
                    $(".error-text").each(function() {
                        if(!$(this).hasClass("hidden")){
                            $(this).css('color', 'rgb(230, 15, 15)')
                            $(this).addClass("hidden")
                        }
                    })
                    if(!modal.hasClass("hidden")){
                        delay = 501
                        $(".contact-actions-modal>div").toggleClass("hidden")
                        setTimeout(function() {
                            modal.toggleClass("hidden")
                        }, 500);
                    }else{
                        $(".contact-actions-modal").get(0).reset()
                        modal.toggleClass("hidden")
                    }
                    setTimeout(function() {
                        if(modal.hasClass("hidden")){
                            $(".add-contact-btn").text("+")
                            $(".add-contact-btn").css('scale', '1')
                            modal.css("transform", "initial")
                        }else{
                            $(".add-contact-btn").text("x")
                            $(".add-contact-btn").css('scale', '0.8')
                            // modal.css('top', '0')
                            modal.css({'transform': 'translateY(' + (modal.parent().height() - parseFloat(modal.css('top'))) + 'px)'})
                            setTimeout(function() {
                                $(".contact-actions-modal>div").toggleClass("hidden")
                            }, 600);
                        }
                    }, delay)
                })
                // edit mode button
                $(".edit-contact-btn").on('click',function (){
                    if(!edit_mode){
                        edit_mode = true
                        $(".edit-contact-btn>svg").css("fill", "rgb(111, 187, 241)")

                    }else{
                        edit_mode = false
                        // $(".edit-contact-btn>svg").css("fill", "white")
                        $(".edit-contact-btn>svg").removeAttr("style")
                    }
                })
            }
            // actually adding new contacts
            $(".create-contact-btn").on('click',function (){
                let name_inp = $(".add-contact-name input")
                let name = name_inp.val()
                let num_inp = $(".add-contact-number input")
                let num = num_inp.val()
                let name_check = false
                let num_check = false

                $(".error-text").each(function() {
                    if(!$(this).hasClass("hidden")){
                        $(this).css('color', 'rgb(230, 15, 15)')
                        $(this).addClass("hidden")
                    }
                })

                if(name){
                    let err_msg = $(".add-contact-name .error-text")
                    if(name.match(/^.{2,12}$/)){
                        name_check = true
                        if(!err_msg.hasClass("hidden")){
                            err_msg.addClass("hidden")
                        }
                    }else{
                        err_msg.text("*Name must be between 2 to 12 characters.")
                        err_msg.removeClass("hidden")
                    }
                }else{
                    $(".add-contact-name .error-text").text("*Please provide a name for the contact.")
                    $(".add-contact-name .error-text").removeClass("hidden")
                }

                if(num){
                    let err_msg = $(".add-contact-number .error-text")
                    if(num[0] == "0"){
                        num = num.slice(1, num.length)
                        num_inp.val(num)
                    }
                    if(num.match(/^[6789][0-9]{9}$/)){
                        num_check = true
                        if(!err_msg.hasClass("hidden")){
                            err_msg.addClass("hidden")
                        }
                    }else{
                        err_msg.text("*Please enter a valid phone number.")
                        err_msg.removeClass("hidden")
                    }
                }else{
                    $(".add-contact-number .error-text").text("*Please provide the contact number.")
                    $(".add-contact-number .error-text").removeClass("hidden")
                }

                if(name_check && num_check){
                    $.ajax({
                        url: "index/add_contact",
                        type: "POST",
                        data: {
                            "name" : name,
                            "number" : num
                        },
                        success: function (response){
                            response = JSON.parse(response);
                            for(let res in response){
                            // Object.values(response).forEach(v => {
                                if(res == "code"){
                                    let err_msg = $(".add-contact-number .error-text")
                                    switch(response[res]){
                                        case 0:
                                            err_msg.text("*Successfully added.")
                                            err_msg.css('color', 'green')
                                            err_msg.removeClass("hidden")
                                            refresh_contacts()
                                            break
                                        case 1:
                                            err_msg.text("*You cannot add yourself as a contact.")
                                            err_msg.removeClass("hidden")
                                            break
                                        case 2:
                                            err_msg.text("*No user with the given number found.")
                                            err_msg.removeClass("hidden")
                                            break
                                    }
                                }
                            };
                        },
                        error: function (response) {
                            console.log(response);
                        }
                    });
                // }else{
                //     $(".add-contact-number .error-text").val("*Please provide both a name and a number.")
                }
            })

            $(".contacts-container .contact-card").each(function(){
                $(this).on("click", function(){
                    if(edit_mode){
                        
                    }
                })
            })
        }
    </script>
</body>
</html>