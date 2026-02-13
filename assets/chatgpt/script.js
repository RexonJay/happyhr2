const input = document.querySelector('input')
const sendbuton = document.querySelector('button')
const input2 = document.querySelector("textarea")
const chatContainer = document.querySelector('.chats')

const element = document.getElementById("myBtn");
const btnsender = document.getElementById("btnsender");
const btnchatbotclose = document.getElementById("closechatmodal");

const smileyIcons = document.querySelectorAll('.smiley-icon');
smileyValue = '';
employeeengagement_lastid = '';

var currentUrl1 = window.location.href;
var baseUrl1 = currentUrl1.split('/index.php')[0];
var resultUrl1 = baseUrl1 + '/index.php';

smileyIcons.forEach((icon) => {

    icon.addEventListener('click', () => {
        
        smileyValue = icon.getAttribute('data-smiley');

        $.ajax({
            url: resultUrl1 + '/EmployeeEngagement/MentalCheckChatBot_Save',
            method:"POST",
            data:{employeeengagement_lastid:employeeengagement_lastid, Answer1:smileyValue},
            dataType:"json",
            success:function(data){
                employeeengagement_lastid = data.employeeengagement_lastid;
                
            }
          });

        const message = `<div class="message"><div>${smileyValue}</div></div>`
        chatContainer.innerHTML += message
        scrollDown();

        setTimeout(() => {
            addWritingAnimation();
        }, 1000);

       // Simulate a bot response after the writing animation
        setTimeout(() => {
            removeWritingAnimation();
            botSmileyResponse(smileyValue); // Replace with the desired smileyValue
        }, 2000); // Adjust the timeout as needed (e.g., 2000ms for a 1-second writing animation)

       
    });
});

sendbuton.onclick = () => {
    //alert(input.value);
    if(input.value){
        
        addWritingAnimation();
        
        const message = `<div class="message"><div>${input.value}</div></div>`
        chatContainer.innerHTML += message
        $.ajax({
            url: resultUrl1 + '/EmployeeEngagement/MentalCheckChatBot_Save',
            method:"POST",
            data:{employeeengagement_lastid:employeeengagement_lastid, Answer2:input.value},
            dataType:"json",
            success:function(data){
                removeWritingAnimation();
                bot();
            }
          });
    
        // Simulate a bot response after the writing animation
        // setTimeout(() => {
        //  removeWritingAnimation();
        //  bot();
        // }, 2000); // Adjust the timeout as needed (e.g., 2000ms for a 1-second writing animation)

        input.value = null
    }
}

// when click enter
element.addEventListener("click", function(e){
    sendbuton.click();
})

// when click enter
input.addEventListener("keypress", function(e){
    if(e.key === "Enter"){
        e.preventDefault();
        sendbuton.click();
    }
})

// scroll down when new message added
function scrollDown(){
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

// bot response
function bot(){



    console.log(input.value);

    switch (smileyValue) {
        case 'Hopeless':
            responseText = "I appreciate you opening up. Remember, you're not alone, and we're here to support you. I'll connect with you again soon. Take care and keep going! 😘";
            break;
        case 'Lonely':
            responseText = "Thanks for sharing. Your feelings matter, and I'm inspired by your openness. Whenever you want to connect or share more, I'll be here cheering you on. I'll connect with you again! Take care. 😘";
            break;
        case 'Sad':
            responseText = "It's okay to feel this way, and I appreciate you sharing. Remember, brighter days are ahead! Until next time, take care! 😘";
            break;
        case 'Happy':
            responseText = "Thanks for sharing your happiness. Keep spreading that happiness, and whenever you want to chat or celebrate, count me in. Take care and keep shining!";
            break;
        case 'Very Happy':
            responseText = "Your joy is inspiring, and I'm grateful for the positivity you've shared. Whenever you want to spread more happiness or just chat about the good stuff, I'm here. Take care and enjoy the moments!";
            break;
        default:
            responseText = "Thanks for sharing. I'm here to chat!";
    }
    chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
    scrollDown();
    btnsender.style.display = "none";
    btnchatbotclose.style.display = "block";

}


// Function to generate bot response based on the clicked smiley
function botSmileyResponse(smileyValue) {
    let responseText = '';

    switch (smileyValue) {
        case 'Hopeless':
            responseText = "I'm really sorry to hear that. It's important to remember that you're not alone, and we're here to support you.";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            responseText = "If you're comfortable, can you tell me more?";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            btnsender.style.display = "block";
            btnchatbotclose.style.display = "none";
            break;
        case 'Lonely':
            responseText = "Feeling lonely can be tough, but I'm here to chat and keep you company. Your feelings matter, and I'm inspired by your openness. If you want to share what's on your mind, I'm ready to listen and support you.";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            responseText = "Can you tell me more?";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            btnsender.style.display = "block";
            btnchatbotclose.style.display = "none";
            break;
        case 'Sad':
            responseText = "I'm sorry to hear that you're feeling sad. It's okay to feel this way, and I'm here to help.";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            responseText = "If you'd like to talk about what's going on or if there's anything specific on your mind, can you tell me more?";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            btnsender.style.display = "block";
            btnchatbotclose.style.display = "none";
            break;
        case 'Happy':
            responseText = "Fantastic to hear you're feeling very happy! 😍 Your positivity is truly uplifting and contagious. 😊 If there's something special making you feel this way, I'd love to know.";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            btnsender.style.display = "block";
            btnchatbotclose.style.display = "none";
            // addWritingAnimation()
            // setTimeout(() => {
            //  removeWritingAnimation();
            //  responseText = "Whenever you want to talk more, I'll be here. Take care! 😘";
            //  chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            //  scrollDown();
            //  btnchatbotclose.style.display = "block";
            // }, 1500);
            break;
        case 'Very Happy':
            responseText = "That's wonderful to hear that you're feeling very happy! 😍 If there's something special that's making you feel this way, I'd love to hear about it. Sharing positive moments can be uplifting.";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            btnsender.style.display = "block";
            btnchatbotclose.style.display = "none";
            // addWritingAnimation()
            // setTimeout(() => {
            //  removeWritingAnimation();
            //  responseText = "I'll connect with you again. Take care and enjoy the moments! 😘";
            //  chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
            //  scrollDown();
            //  btnchatbotclose.style.display = "block";
            // }, 1500);
            
            break;
        default:
            responseText = "Thanks for sharing. I'll connect with you again!!";
            chatContainer.innerHTML += `<div class="message response"><div>${responseText}</div></div>`;
    }

    
    scrollDown();
}

// Function to add the writing animation
function addWritingAnimation() {
    chatContainer.innerHTML += `
        <div class="message response">
            <div class="writing-animation">
            <img src="${baseUrl1}/assets/chatgpt/img/preloader.gif" alt="preloader">
            </div>
        </div>
    `;
    scrollDown();
}

// Function to remove the writing animation
function removeWritingAnimation() {
    const writingAnimation = document.querySelector('.writing-animation');
    if (writingAnimation) {
        writingAnimation.parentNode.removeChild(writingAnimation);
    }
}