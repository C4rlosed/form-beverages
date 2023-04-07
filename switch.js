function toggleColors() {
    var body = document.getElementsByTagName("body")[0];
    var container = document.getElementsByClassName("container")[0];
    body.classList.toggle("cor1");
    container.classList.toggle("cor1");
    body.classList.toggle("cor2");
    container.classList.toggle("cor2");
}