<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chronicle AI</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">  
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
                <img src="{{ asset('favicon.svg') }}" alt="Profil Ai" class="profimg">
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
    </form>
</div>

    <script>
         document.getElementById('user-input').addEventListener('keydown', function (event) {
        // Periksa apakah tombol yang ditekan adalah tombol "Enter" (kode 13)
        if (event.keyCode === 13) {
            // Cegah aksi default (misalnya, mengirimkan formulir)
            event.preventDefault();
            // Panggil fungsi sendMessage
            sendMessage();
        }
    });

         // Fungsi untuk menangani perubahan input dan mengubah warna latar belakang
    function handleInputChange() {
        var inputElement = document.getElementById('user-input');
        var sendButton = document.querySelector('.send-button');

        // Jika input tidak kosong, ubah warna latar belakang menjadi warna yang diinginkan
        if (inputElement.value.trim() !== '') {
            sendButton.style.backgroundColor = '#ffffff'; // Ganti dengan warna yang diinginkan
        } else {
            // Jika input kosong, kembalikan warna latar belakang ke warna awal
            sendButton.style.backgroundColor = '#2c2c32'; // Ganti dengan warna awal
        }
    }

    // Tambahkan event listener untuk mendengarkan perubahan pada input
    document.getElementById('user-input').addEventListener('input', handleInputChange);
            // Fungsi untuk menangani perubahan ukuran input container saat di-focus
    function handleInputFocus() {
        var inputContainer = document.querySelector('.input-container');
        inputContainer.classList.remove('small'); // Hapus class 'small' jika ada
        inputContainer.classList.add('focus'); // Tambah class 'focus' saat di-focus
    }

    // Fungsi untuk menangani perubahan ukuran input container saat kehilangan focus
    function handleInputBlur() {
        var inputContainer = document.querySelector('.input-container');
        // Tambah class 'small' setelah kehilangan focus
        if (!document.activeElement.closest('.input-container')) {
            inputContainer.classList.remove('focus');
            inputContainer.classList.add('small');
        }
    }

    // Tambahkan event listener untuk menangani focus dan blur pada input
    document.getElementById('user-input').addEventListener('focus', handleInputFocus);
    document.getElementById('user-input').addEventListener('blur', handleInputBlur);


function sendMessage() {
    var chatForm = document.getElementById('chat-form');
    var userInput = chatForm.elements.user_input.value;
    var chatContainer = document.getElementById('chat');

    // Display user's message with profile
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

    // Send user's message to the server and get AI response
    fetch('https://api.openai.com/v1/chat/completions', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer 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',
    },
    body: JSON.stringify({
        model: 'gpt-3.5-turbo-0613',  // Sesuaikan dengan model yang ingin Anda gunakan
        messages: [
            { role: 'system', content: 'You are a helpful assistant.' },
            { role: 'user', content: userInput },
        ],
    }),
})
    .then(response => response.json())
    .then(data => {
    console.log(data);  // Tambahkan ini untuk melihat struktur objek respons AI di konsol
    console.log(data.choices[0].text);  // Tambahkan ini untuk melihat struktur objek respons AI di konsol
        // Display AI's response with profile
        var aiMessage = document.createElement('div');
        aiMessage.className = 'ai-message';

        var aiMessageContainer = document.createElement('div');
        aiMessageContainer.className = 'message-container';
        aiMessage.appendChild(aiMessageContainer);

        var aiProfile = document.createElement('div');
        aiProfile.className = 'profile ai-profile';
        aiMessageContainer.appendChild(aiProfile);

        var aiMessageContent = document.createElement('div');
        aiMessageContent.className = 'message';

        // Access the 'text' property from the JSON data
        aiMessageContent.textContent = data.choices[0].text;

        aiMessageContainer.appendChild(aiMessageContent);

        chatContainer.appendChild(aiMessage);
    })
    .catch(error => {
    console.error('Error:', error);
});


    // Clear input
    chatForm.reset();
}

    </script>
</body>
</html>
