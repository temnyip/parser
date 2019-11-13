document.addEventListener("DOMContentLoaded", createPage);
function send(event)
{
    event.preventDefault();
    fetch("index1.php", {method: "POST", body: new FormData(document.forms[0])})
        .then(response => response.text())
        .then(text => {document.querySelector('.output').innerHTML = text;
        })
}
function createPage() {
    let container = document.createElement("div");
    container.classList.add("container");
    document.body.append(container);

    let header = document.createElement("div");
    header.classList.add("header");
    header.innerText = "PARSER";
    container.append(header);

    let info = document.createElement("div");
    info.classList.add("info");
    container.append(info);

    let form = document.createElement("form");
    form.id = "form";
    info.append(form);

    let button = document.createElement("input");
    button.classList.add("buttonReg");
    button.type = "submit";
    button.name = "button";
    button.onclick = send;
    button.value = "Parser";
    form.append(button);

    let footer = document.createElement("div");
    footer.classList.add("footer");
    footer.innerText = "Copyright by..., 2019";
    container.append(footer);
}

