const $sendButton = document.getElementById('send');
const $input = document.getElementById('message');
const $messages = document.querySelector('div.messages');

window.onload = () => {
    const socket = new Socket('ws://localhost:8080');

    socket.on('open',() => {
        console.log("Connection established!");
    });
    socket.on('message', (message) => {
        showMessage(message)
    });

    $sendButton.addEventListener('click', () => {
        let message = $input.value;
        if (message.trim() !== '') {
            socket.emit(message);
            showMessage(message,true);
            $input.value = '';
        }
    });

    $input.addEventListener('keypress', (e) => {
        if (e.keyCode === 13) {
            $sendButton.click();
        }
    })
};


class Socket {
    constructor(url) {
        try {
            this.socket = new WebSocket(url);
        } catch (e) {
            console.error('Websocket connection error:', e.message)
        }
    }

    emit(message) {
        this.socket.send(message);
    }

    on(name, callback) {
        this.socket.addEventListener(name, (e) => {
            if (e) {
                if (e.data) {
                    callback(e.data)
                } else {
                    callback(e)
                }
            } else {
                callback()
            }
        });
    }
}


const showMessage = (message,self) => {

    let p = document.createElement('p');

    p.classList.add('p-1','shadow','bg-light','rounded');

    if (self) {
        p.classList.add('text-right','text-success')
    } else {
        p.classList.add('text-warning')
    }
    p.textContent = message;

    $messages.append(p);
}


