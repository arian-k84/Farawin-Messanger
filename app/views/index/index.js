let contacts;
let currently_selected;
{ // loading functions/refreshing contacts
    // refreshing contacts
    let card;
    function refresh_contacts(num = false){
        card = $(".contacts-container>.contact-card:first").clone(true)
        card.removeClass("hidden")
        card.removeAttr("style")
        card.children(".message-wrapper").children().removeAttr("style")
        $(".main-container>.contact-wrapper>.contacts-container").empty()
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
                    new_card.data('name', i["name"])
                    new_card.data('contact-id', i["contact_id"])
                    new_card.data('contact-number', i["contact_pnumber"])
                    if(i["contact_pnumber"] == num){
                        new_card.data('selected', true)
                        new_card.css("background-color", "rgb(255, 202, 56)")
                        new_card.children(".message-wrapper").children().css("color", "white")
                        currently_selected = new_card
                    }else{
                        new_card.data('selected', false)
                    }
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
    function load_messages(contact){
        $.ajax({
            url: "index/load_contact_messages",
            type: "POST",
            data: {
                "contact-id" : contact.data("contact-id"), 
            },
            success: function (response){
                response = JSON.parse(response);
                message_data = []
                for(let [val, i] of response.entries()){
                    message_data.push(i)
                };
                message_data.sort((a, b) => a.id - b.id);
                $("#messenger-container #messages-container").children().empty()
                message_data.forEach(function(data){
                    if(data["sender_id"] == contact.data("contact-id")){
                        $("#messenger-container #messages-container").children().append("<p class='contact-message'>" + data["message"] + "</p>")
                    }else{
                        $("#messenger-container #messages-container").children().append("<p class='user-message'>" + data["message"] + "</p>")
                    }
                    
                })
            },
            error: function (response) {
                alert("Server-side error.");
            }
        });
    }
}
{ // contact functions
    { // modals
        // opening the add contact modal
        let main_open = false
        $(".add-contact-btn").on('click',function (){
            let modal = $(".contact-actions-modal")
            $(".error-text").each(function() {
                if(!$(this).hasClass("hidden")){
                    $(this).css('color', 'rgb(230, 15, 15)')
                    $(this).addClass("hidden")
                }
            })
            if(main_open){
                $(".contact-actions-modal>form>div").toggleClass("hidden")
                $( ".add-contact-btn" ).css('transform', 'initial')
                main_open = false
                setTimeout(function() {
                    modal.css("transform", "initial")
                }, 500)
                setTimeout(function() {
                    modal.toggleClass("hidden")
                }, 900);
                
            }else{
                $(".contact-actions-modal>form").get(0).reset()
                modal.toggleClass("hidden")
                main_open = true
                $( ".add-contact-btn" ).css({
                    transform: "rotate(45deg)"
                });
                modal.css({'transform': 'translateY(' + (-parseFloat(modal.css('top'))) + 'px)'})
                setTimeout(function() {
                    $(".contact-actions-modal>form>div").toggleClass("hidden")
                }, 600);
            }
        })
        // edit mode button
        $("#messenger-container>#messenger-wrapper>#top-bar>#options-btn").on('click',function (){
            let profile = $(".main-wrapper>.profile-popup>#profile-container")
            profile.find("#info-section>div #name").text(currently_selected.data("name"))
            profile.find("#info-section>div #phone-number").text(currently_selected.data("contact-number"))
            $(".main-wrapper>.profile-popup").toggleClass("hidden")
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
    // profile close button
    $(".profile-popup>#profile-container>#top-section>#close-btn").on('click', function(){
        $(".main-wrapper>.profile-popup").addClass("hidden")
    })
    // profile name change
    name_change = false
    $(".profile-popup>#profile-container>#info-section>div #change-name").on('click', function(){
        if(!name_change){
            $(this).text("Confirm?")
            let name = $(".profile-popup>#profile-container>#info-section>div #name")
            name.attr("contentEditable", true);
            name.css({
                "color": "white",
                "background-color": "rgb(46, 46, 46)",
                "border": "0",
                "border-radius": "3px",
            })
            name_change = true
        }else{
            $(this).text("Change")
            let name = $(".profile-popup>#profile-container>#info-section>div #name")
            let pnumber = $(".profile-popup>#profile-container>#info-section>div #phone-number").text()
            name.attr("contentEditable", false);
            name.removeAttr('style');
            
            // console.log($('.contacts-container').find(`.contact-card[data-contact-number='9378764087']`).data('contact-id'))

            $.ajax({
                url: "index/edit_contact",
                type: "POST",
                data: {
                    "name" : name.text(),
                    "contact-number" : pnumber,
                },
                success: function (response){
                    let response2 = JSON.parse(response)
                    refresh_contacts(pnumber)
                    $(".main-wrapper>.profile-popup").addClass("hidden")
                    // response = JSON.parse(response);
                    // for(let res in response){
                    // };
                },
                error: function (response) {
                    console.log(response);
                }
            });
            name_change = false
        }
    })
    
    $(".contacts-container .contact-card").each(function(){
        $(this).on("click", function(){
            if($(this).data("selected") == false){
                $(".contacts-container .contact-card").each(function(){
                    $(this).data("selected", false)
                    $(this).css("background-color", "")
                    $(this).children(".message-wrapper").children().css("color", "")
                })
                let data;
                let wrapper = $("#messenger-container>#messenger-wrapper")
                $(this).data("selected", true)
                $(this).css("background-color", "rgb(255, 202, 56)")
                $(this).children(".message-wrapper").children().css("color", "white")
                wrapper.css("display", "initial")
                $("#messenger-container>#cover").addClass("hidden")
                load_messages($(this))
                
                setTimeout(function() {
                    wrapper.removeClass("hidden")
                }, 300)
                currently_selected = $(this)
                wrapper.children("#top-bar").children("#contact-info").children("p").text($(this).data('name'))

            }
        })
    })
}
{ // messaging functions
    $("#messenger-container #bottom-bar #message-buttons>#send-button").on("click", function(){
        let message = $("#messenger-container #bottom-bar #message-input>input").val()
        if(message.length > 0){
            $.ajax({
                url: "index/send_message",
                type: "POST",
                data: {
                    "recipient_id" : currently_selected.data("contact-id"),
                    "message" : message
                },
                success: function (response){
                    response = JSON.parse(response);
                    load_messages(currently_selected)
                    $("#messenger-container #bottom-bar #message-input>input").val('')
                },
                error: function (response) {
                    alert("Server-side error.")
                }
            });
        }
    })
}