const projectName = document.querySelector("#projectName");
const taskName = document.querySelector("#taskName");
const tasksForm = document.querySelector("#tasks-form");

tasksForm.addEventListener("submit", (e) => {
    e.preventDefault();
    let newTaskName = taskName.value.trim();
    if (newTaskName.length === 0) {
        alert("Please enter a task name");
        return;
    }
    tasksForm.submit();
});

projectName.addEventListener("change", (e) => {
    window.location = "/get-tasks/" + projectName.value;
});

const selectedProject = document.querySelector("#selectedProject");
selectedProject.insertAdjacentHTML("beforeend", projectName.value);

var draggingElement = null;
var draggingFrom = 0;
var draggingTo = 0;

function handleDragStart(e) {
    // Target (this) element is the source node.
    this.style.opacity = "0.8";

    draggingElement = this;
    e.dataTransfer.effectAllowed = "move";
    e.dataTransfer.setData("text/html", this.innerHTML);

    draggingFrom = this.id;
    // console.log("Drag started", this.id);
}

function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault(); // Necessary. Allows us to drop.
    }

    e.dataTransfer.dropEffect = "move"; // See the section on the DataTransfer object.
    return false;
}

function handleDragEnter(e) {
    // this / e.target is the current hover target.
    // this.classList.add("over");
    this.style.opacity = "0.4";
}

function handleDragLeave(e) {
    // this.classList.remove("over"); // this / e.target is previous target element..
    this.style.opacity = "1";
}

function handleDrop(e) {
    // this/e.target is current target element.

    if (e.stopPropagation) {
        e.stopPropagation(); // Stops some browsers from redirecting.
    }

    // Don't do anything if dropping the same column we're dragging.
    if (draggingElement != this) {
        // Set the source column's HTML to the HTML of the column we dropped on.
        draggingElement.innerHTML = this.innerHTML;
        this.innerHTML = e.dataTransfer.getData("text/html");
    }
    draggingTo = this.id;

    $.ajax({
        type: "POST",
        url: "/api/sync-task",
        data: JSON.stringify({
            draggingFrom: draggingFrom,
            draggingTo: draggingTo,
            projectName: projectName.value,
        }),
        contentType: "application/json",
        dataType: "json",
        success: function (data) {
            location.reload();
        },
    });

    return false;
}

function handleDragEnd(e) {
    // this/e.target is the source node.

    [].forEach.call(cols, function (col) {
        col.classList.remove("over");
    });
}

var cols = document.querySelectorAll(".singleTask .dragable");
[].forEach.call(cols, function (col) {
    col.addEventListener("dragstart", handleDragStart, false);
    col.addEventListener("dragenter", handleDragEnter, false);
    col.addEventListener("dragover", handleDragOver, false);
    col.addEventListener("dragleave", handleDragLeave, false);
    col.addEventListener("drop", handleDrop, false);
    col.addEventListener("dragend", handleDragEnd, false);
});
