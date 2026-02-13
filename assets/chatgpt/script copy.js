const input = document.querySelector('input')
const sendbuton = document.querySelector('button')
const input2 = document.querySelector("textarea")
const chatContainer = document.querySelector('.chats')

const element = document.getElementById("myBtn");

sendbuton.onclick = () => {
    console.log(1);
    if(input.value){
        const message = `
            <div class="message">
                <div>
                    ${input.value}
                </div>
            </div>
        `
        chatContainer.innerHTML += message
        scrollDown();
        bot()   
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
    var http = new XMLHttpRequest()
    var data = new FormData()
    data.append('prompt', input.value)
    data.append('prompt2', input2.value)
    http.open('POST', 'chatbot/request', true)
    http.send(data)
    setTimeout(() => {
        chatContainer.innerHTML += `
            <div class="message response">
                <div>
                    <img src="../assets/chatgpt/img/preloader.gif" alt="preloader">
                </div>
            </div>
        `
        scrollDown();
    }, 1000);
    http.onload = () => {
        var response = JSON.parse(http.response)
        console.log(http.response);
        //console.log(JSON.parse(http.response));
        // //IF GET
        // console.log(response);
        // console.log(response.text);
        // var replyText = response.text;

        //IF POST
        console.log(response.reply.text);
        var replyText = response.reply.text
        // //var replyText = processResponse(response.data.text)
        // //console.log(replyText);
        // //var replyText = response.choices[0].text
        var replyContainer = document.querySelectorAll('.response')
        replyContainer[replyContainer.length-1].querySelector('div').innerHTML = replyText
        scrollDown();
    }
}

function processResponse(res){
    var arr = res.split(':')
    return arr[arr.length-1]//.replace(/(\r\n|\r|\n)/gm, '')
    //.trim()
    // return arr[arr.length-1]
    //     .replace(/(\r\n|\r|\n)/gm, '')
    //     .trim()
}