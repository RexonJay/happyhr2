const input = document.querySelector('input')
const button = document.querySelector('button')
const textarea = document.querySelector('textarea')

input.addEventListener("keypress", function(event) {
if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("myBtn").click();
}
});

var communicator = ''
button.onclick = () => {
    var prompt = input.value
    if(prompt != ''){
        bottomScroll();
        (textarea.innerHTML == '') ? communicator = 'You: ' : communicator = '\n\nYou: '
        textarea.innerHTML += communicator + prompt
        // use SSE to get server Events
        var source = new SSE("Chatbot?prompt=" + prompt);
        input.value = ''
        input.focus()
        source.addEventListener('message', function (e) {
            if(e.data){
                if(e.data != '[DONE]'){
                    var tokens = JSON.parse(e.data).choices[0].text
                    textarea.innerHTML += tokens
                    bottomScroll();
                }else{
                    console.log('Completed');
                }
            }
        })
        source.stream()
    }
}



function bottomScroll(){
    textarea.scrollIntoView(false)
    textarea.scrollTo(0, textarea.scrollHeight)
}