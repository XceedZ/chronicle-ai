<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chronicle AI</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">  
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" style="filter: invert(1);">
    <script src="https://kit.fontawesome.com/16194211d5.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <div class="navbar">
            <div class="logo"><img src="{{ asset('logo.svg') }}" alt="Logo" style="filter: invert(1);"></div>
            <ul>
                <li><a href="#" class="menu-chat active">AI Chat</a></li>
                <li><a href="#" class="menu-vid">AI Images</a></li>
                <li><a href="#" class="menu-img">AI Summarizer</a></li>
                <li><a href="#" class="menu-changelog">Changelog</a></li>
            </ul>
        </div>
    </nav>
    <div class="chat-container">
        <div class="chat" id="chat">
            <!-- User's message with profile -->
            <div class="user-message">
                <div class="message-container">
                    <div class="profile user-profile"></div>
                    <div class="message">Halo, apa kabar?</div>
                </div>
            </div>
        
            <!-- AI's response with profile -->
            <div class="ai-message">
                <div class="message-container">
                    <div class="profile ai-profile"></div>
                    <img src="{{ asset('favicon.svg') }}" alt="Profil AI" class="profimg">
                    <div class="message">Halo! Saya baik, terima kasih. Bagaimana dengan Anda?</div>
                </div>
            </div>
        </div>
    
        <!-- Input box -->
        <div class="input-container">
            <form id="chat-form">
                @csrf
                <input type="text" id="user-input" name="user_input" placeholder="Ask me anything...">
                <div class="send-button" onclick="sendMessage()">
                    <img src="{{ asset('send.png') }}" alt="Kirim">
                </div>
            </form>
        </div>

        <script>
      function adjustChatContainer() {
    var chatContainer = document.querySelector('.chat');
    var inputContainer = document.querySelector('.input-container');
    var windowHeight = window.innerHeight;
    var inputContainerHeight = inputContainer.offsetHeight;
    var keyboardHeight = windowHeight - (window.innerHeight - window.innerHeight/3); // Misalnya, Anda dapat mengurangi setengah dari tinggi window saat keyboard muncul

    // Jika keyboard muncul, kurangi tinggi chat container
    if (keyboardHeight > 0) {
        chatContainer.style.height = windowHeight - inputContainerHeight - keyboardHeight + 'px';
    } else {
        // Jika keyboard tidak muncul, kembalikan tinggi chat container ke tinggi aslinya
        chatContainer.style.height = windowHeight - inputContainerHeight + 'px';
    }

    // Aktifkan scroll otomatis pada chat container
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

// Panggil fungsi adjustChatContainer() ketika keyboard muncul atau disembunyikan
window.addEventListener('resize', adjustChatContainer);

// Panggil fungsi adjustChatContainer() saat halaman dimuat
window.addEventListener('load', adjustChatContainer);



            
            document.getElementById('user-input').addEventListener('keydown', function (event) {
                // Periksa apakah tombol yang ditekan adalah tombol "Enter" (kode 13)
                if (event.keyCode === 13) {
                    // Cegah aksi default (misalnya, mengirimkan formulir)
                    event.preventDefault();
                    // Panggil fungsi sendMessage
                    sendMessage();
                }
            });


            function handleInputChange() {
                var inputElement = document.getElementById('user-input');
                var sendButton = document.querySelector('.send-button');

                if (inputElement.value.trim() !== '') {
                    sendButton.style.backgroundColor = '#ffffff';
                } else {
                    sendButton.style.backgroundColor = '#2c2c32';
                }
            }

            document.getElementById('user-input').addEventListener('input', handleInputChange);

            function handleInputFocus() {
                var inputContainer = document.querySelector('.input-container');
                inputContainer.classList.remove('small');
                inputContainer.classList.add('focus');
            }

            function handleInputBlur() {
                var inputContainer = document.querySelector('.input-container');
                if (!document.activeElement.closest('.input-container')) {
                    inputContainer.classList.remove('focus');
                    inputContainer.classList.add('small');
                }
            }

            document.getElementById('user-input').addEventListener('focus', handleInputFocus);
            document.getElementById('user-input').addEventListener('blur', handleInputBlur);

            function sendMessage() {
                var chatForm = document.getElementById('chat-form');
                var userInput = chatForm.elements.user_input.value;
                var chatContainer = document.getElementById('chat');

                var userMessage = document.createElement('div');
                userMessage.className = 'user-message';

                var messageContainer = document.createElement('div');
                messageContainer.className = 'message-container';
                userMessage.appendChild(messageContainer);

                var userProfile = document.createElement('div');
                userProfile.className = 'profile user-profile';
                messageContainer.appendChild(userProfile);

                var messageContent = document.createElement('div');
                messageContent.className = 'message';
                messageContent.textContent = userInput;
                messageContainer.appendChild(messageContent);

                chatContainer.appendChild(userMessage);

                fetch('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=AIzaSyBeikCNyjgNjgoDpW0d_8ICM1dW2b2hjnw', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        "contents":[{
                            "parts":[{
                                "text": userInput
                            }]
                        }]
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    var aiMessage = document.createElement('div');
                    aiMessage.className = 'ai-message';

                    var aiMessageContainer = document.createElement('div');
                    aiMessageContainer.className = 'message-container';
                    aiMessage.appendChild(aiMessageContainer);

                    var aiProfile = document.createElement('div');
                    aiProfile.className = 'profile ai-profile'; // Menambahkan profil AI
                    aiMessageContainer.appendChild(aiProfile);
                    
                    // Menambahkan gambar profil AI ke dalam blok pesan AI
                    var aiProfileImg = document.createElement('img');
                    aiProfileImg.src = "{{ asset('favicon.svg') }}"; // Perubahan tanda kutip di sini
                    aiProfileImg.alt = 'Profil AI';
                    aiProfileImg.className = 'profimg';
                    aiMessageContainer.appendChild(aiProfileImg);


                    var aiMessageContent = document.createElement('div');
                    aiMessageContent.className = 'message';

                    aiMessageContent.textContent = data.candidates[0].content.parts[0].text;

                    aiMessageContainer.appendChild(aiMessageContent);

                    chatContainer.appendChild(aiMessage);
                })
                .catch(error => {
                    console.error('Error:', error);
                });

                chatForm.reset();
            }
        </script>
    </body>
</html>
