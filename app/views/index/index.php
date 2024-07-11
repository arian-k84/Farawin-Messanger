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

        <div class="profile-popup hidden">
            <div id="profile-container">
                <div id="top-section">
                    <button id="close-btn" type="button">+</button>
                    <span>
                        <span>
                            <img id="contact-photo" src="app\views\index\css\user-icon.webp" alt="">
                            <!-- <span id="name">test</span> -->
                        </span>
                    </span>
                </div>
                <div id="info-section">
                    <p>Profile</p>
                    <div>
                        <ul>
                            <div>
                                <p>
                                    Name
                                    <a id="change-name" href="#">Change</a>
                                </p>
                                <li id="name">test</li>
                            </div>

                            <div>
                                <p>Phone number</p>
                                <li id="phone-number">test</li>
                            </div>

                            <div>
                                <p>Bio</p>
                                <li id="bio">Welcome to my profile!</li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="edit-message-popup hidden">
            <div id="controls-container">
                <button id="close-btn">+</button>
                <textarea id="edit-message-area" maxlength="255" wrap="soft"></textarea>
                <div>
                    <button id="confirm">Confirm</button>
                    <button id="delete">Delete</button>
                </div>
            </div>
        </div>

        <div class="main-container">
            <div id="messenger-container">
                <div id="cover">
                    <p>Select a contact to chat with them!</p>
                </div>
                <div id="messenger-wrapper" class="hidden">
                    <div id="top-bar">
                        <div id="contact-info">
                            <button id="mobile-back-btn" class="hidden"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg></button>
                            <div>
                                <img src="app\views\index\css\user-icon.webp" alt="profile picture">
                            </div>
                            <p></p>
                        </div>
                        <button id="options-btn"></button>
                    </div>
                    <div id="messages-container">
                        <div>

                        </div>
                    </div>
                    <div id="bottom-bar">
                        <div>
                            <div id="message-input">
                                <input type="text" placeholder="Write your message here...">
                                <div id="message-buttons">
                                    <button id="send-button">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-wrapper">
                <div class="contact-control">
                    <button title="Add contact" class="add-contact-btn" type="button">+</button>
                    <button title="Log out" class="logout-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg></button>
                    <!-- <button title="Edit mode" class="edit-contact-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg></button> -->

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
                <div class="contact-actions-modal hidden">
                    <form onsubmit="return false;">
                        <div class="hidden">
                            <div class="icon-grid"><p class="modal-info">Add Contact</p></div>
                            <div class="inputs-container">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/jquery-3.4.1.min.js"></script>

    <script src="app\views\index\index.js"></script>
</body>
</html>