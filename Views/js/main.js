// Query Selectors
const addTaskForm = document.querySelector("#id_task_add");
const buttonAddTask = document.querySelector("#addTaskButton");

// let listItems = [];

// Functions
function sendAjax(data, url, method) {
  var xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  //   xhr.onreadystatechange = function () {
  //     if (this.readyState == 4 && this.status == 200) {
  //         document.getElementById("demo").innerHTML = this.responseText;
  //     }
  //   };

  xhr.send(JSON.stringify(data));
}

function addTask() {
  const name = addTaskForm.querySelector("#id_taskName").value;
  const description = addTaskForm.querySelector("#id_taskDescription").value;
  const startDate = addTaskForm.querySelector("#id_dateDebut").value;
  const endDate = addTaskForm.querySelector("#id_dateFin").value;

  const newTask = {
    name,
    description,
    startDate,
    endDate,
  };

  //   console.log(newTask);
  //   sendAjax(newTask);
  sendAjax(
    newTask,
    "http://localhost/mvc/index.php?page=task_add",
    "POST",
    function (err, data) {
      if (err) {
        throw err;
      }
      console.log("ok");
      console.log(data);
    }
  );
  location.href = "http://localhost/mvc/index.php?page=dashboard";

  //   location.href = "http://localhost/mvc/index.php?page=dashboard";

  //   name.target.reset();
  //   description.target.reset();
  //   startDate.target.reset();
  //   endDate.target.reset();
}

// Event Listeners
buttonAddTask.addEventListener("click", addTask);
