const message = document.createElement("p");

const node = document.createTextNode("Вы успешно автоирзовались!");

message.appendChild(node);

const element = document.getElementById("message");
element.appendChild(message);

// Скрываем сообщение через 10 секунд
setTimeout(function () {
    element.style.display = "none";
}, 10000);