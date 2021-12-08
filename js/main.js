// message box fadeout
let msgBox = document.querySelector(".alert-success");
let url = window.location.href.toString();
let taskBox = document.querySelector(".new-task");

// if on new-task and login success pages, change the margin of task card
if (url.includes("msg=login") || url.includes("msg=new_task")) {
    taskBox.style.marginTop = "0";
}

setTimeout(function(){

    if (!msgBox.classList.contains("hide")) {
        msgBox.classList.add("hide");
    } 
    
}, 2500)
