<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Socket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<div class="container bg-dark p-5">
    <div class="row">
        <div class="message-container col-md-4">
            <div class="input-group">
                <input type="text" placeholder="your message" class="form-control" id="message"/>
                <div class="input-group-append">
                    <button id="send" class="btn btn-outline-info">send</button>
                </div>
            </div>

        </div>
        <div class="messages col-md-8 d-flex flex-column shadow h-100 w-100">
            <p class="text-center text-info font-weight-bold">Messages</p>
        </div>
    </div>
</div>
<script src="/socket.js"></script>
</body>
</html>




