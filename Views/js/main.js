/**
 * récupérer les éléments HTML
 */
const addTaskForm = document.querySelector("#id_task_add");
const buttonAddTask = document.querySelector("#addTaskButton");
let taskCreate = true;
let taskToupdateId = null;

// ############################################################################################################################################################################

/**
 * Les fonctions
 */

// ############################################################################################################################################################################

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

// Activer un utilisateur
function activerUtilisateur(element, id_utilisateur) {
  const destinationController = "http://" + element.dataset.host;
  if (element) {
    console.log(element.checked);
    sendAjax(
      { id: id_utilisateur, isChecked: element.checked },
      destinationController + "?page=user_edit",
      "POST",
      function (err, data) {
        if (err) {
          throw err;
        }
        console.log("ok");
        console.log(data);
      }
    );

    setTimeout(function () {
      location.href = destinationController + "?page=manage_users";
    }, 500);
  }
}

// Cette fonction Ajoute une nouvelle tache ou modifie une tache existante en fonction du parametre << tache >> qui a pour valeur par defaut << null >>
function addTask() {
  const destinationController = "http://" + buttonAddTask.dataset.host;
  const name = addTaskForm.querySelector("#id_taskName");
  const description = addTaskForm.querySelector("#id_taskDescription");
  const startDate = addTaskForm.querySelector("#id_dateDebut");
  const endDate = addTaskForm.querySelector("#id_dateFin");

  // Validation
  let errors = [];

  if (name.value == "") {
    errors.push("Veuillez entrer un nom de tâche");
    name.focus();
  }
  if (description.value == "") {
    errors.push("Veuillez entrer une description");
    description.focus();
  }
  if (startDate.value == "") {
    errors.push("Veuillez entrer une date de début");
    // startDate.focus();
  }
  if (endDate.value == "") {
    errors.push("Veuillez entrer une date de fin");
    // endDate.focus();
  }
  if (transformeDate(startDate.value) > transformeDate(endDate.value)) {
    errors.push("La date de fin ne peut être inférieure à la Date de début");
    endDate.value = "";
  }

  // Mettre a jour ou creer une nouvelle tache en fonction de la valeur de << taskCreate >> true (creer) - false (mettre a jour)

  if (errors.length == 0) {
    const newTask = {
      createTask: taskCreate,
      id: taskToupdateId,
      name: name.value,
      description: description.value,
      startDate: startDate.value,
      endDate: endDate.value,
    };

    sendAjax(
      newTask,
      destinationController + "?page=task_add",
      "POST",
      function (err, data) {
        if (err) {
          throw err;
        }
        console.log("ok");
        console.log(data);
      }
    );
    location.href = destinationController + "?page=dashboard";
  } else {
    alert(errors.join("\n"));
  }
}

// Suppriner une tache
function supprimerTache(data_host, id) {
  const destinationController = "http://" + data_host;

  const remove = confirm("Suppprimer la tâche ?");

  if (remove) {
    // Supprimer la tache si l'utilisateur confirme
    sendAjax(
      { id: id },
      destinationController + "?page=task_delete",
      "POST",
      function (err, data) {
        if (err) {
          throw err;
        }
        console.log("ok");
        console.log(data);
      }
    );
    location.href = destinationController + "?page=dashboard";
  }
}

// Recuperer la tache a mettre a jour
function getTaskToUpdate(tacheId = null, tache = null, update = false) {
  if (!update) {
    if (tacheId) {
      // Reconstituer la tache complete et la mettre a jour
      return {
        id: tache.id,
        name: tache.name,
        description: tache.description,
        startDate: tache.date_debut,
        endDate: tache.date_fin,
      };
    }
  } else {
    //
  }

  return null;
}

// Gerer l'affichage la fenetre modale
function showModal(tacheId = null, tacheBrut = null) {
  // console.log(tacheBrut);

  // Decoder ou deserialiser la tache
  // tacheBrut = decodeURIComponent(tacheBrut);

  let taskModal = document.getElementById("id_modal_tache");
  let modalTitle = taskModal.querySelector("#idTaskModalTitle");
  let taskModalPopup = new bootstrap.Modal(taskModal, {});

  let modalBodyInput = taskModal.querySelector("#id_task_add");

  let name = modalBodyInput.querySelector("#id_taskName");
  let description = modalBodyInput.querySelector("#id_taskDescription");
  let startDate = modalBodyInput.querySelector("#id_dateDebut");
  let endDate = modalBodyInput.querySelector("#id_dateFin");

  if (tacheId && tacheBrut) {
    taskModal.addEventListener("show.bs.modal", function () {
      tache = getTaskToUpdate(tacheId, tacheBrut);
      taskCreate = false;
      taskToupdateId = tacheId;

      if (tache) {
        modalTitle.textContent =
          "Modifier la tache : " + tache.name.substring(0, 15);

        name.value = tache.name;
        description.value = tache.description;
        startDate.value = tache.startDate;
        endDate.value = tache.endDate;
      }
    });
  } else {
    taskCreate = true;
    taskToupdateId = null;

    taskModal.addEventListener("show.bs.modal", function () {
      name.value = "";
      description.value = "";
      startDate.value = "";
      endDate.value = "";

      modalTitle.textContent = "Ajout d'une nouvelle tâche";
    });
    // modalTitle.textContent = "Ajout d'une nouvelle tâche";
  }

  // modalBodyInput.value = "error";
  taskModalPopup.show();
}

// Transformer une date du fomat String ("jj-MM-AAAA") à un Objet Date Javascript
function transformeDate(dateString) {
  // Transformer la date debut
  const dateParts = dateString.split("-");
  const processedDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

  return processedDate;
}

// Terminer une tache (Travailleur)
function terminerTache(element, id) {
  const destinationController = "http://" + element.dataset.host;
  // Verifier si l'element (checkbox) change d'etat
  if (element.checked) {
    sendAjax(
      { id: id },
      destinationController + "?page=task_add",
      "POST",
      function (err, data) {
        if (err) {
          throw err;
        }
        console.log("ok");
        console.log(data);
      }
    );

    setTimeout(function () {
      location.href = destinationController + "?page=dashboard";
    }, 500);
  }
}

// Attribuer une tache
function setTask(data_host, id_tache) {
  const destinationController = "http://" + data_host;
  let attribuerModalElement = document.getElementById("id_attribuer_tache");
  let modalTitle = attribuerModalElement.querySelector(
    "#id_attribuer_tache_titre"
  );
  let attribuerTacheModalPopup = new bootstrap.Modal(attribuerModalElement, {});

  let listeTravailleurs = document.querySelector("#id_liste_travailleurs");
  let boutonEnregisterOperation = document.querySelector(
    "#id_enregistrer_tache_attribuee"
  );

  // Enregister en BD lorsque le bouton 'Enregister' est clique
  boutonEnregisterOperation.addEventListener("click", (event) => {
    if (listeTravailleurs.value != "0") {
      sendAjax(
        {
          idTache: id_tache,
          idUser: listeTravailleurs.value,
          attribuerTache: true,
        },
        destinationController + "?page=task_add",
        "POST",
        function (err, data) {
          if (err) {
            throw err;
          }
          console.log("ok");
          console.log(data);
        }
      );

      // Rediriger vers le Dashboard
      location.href = destinationController + "?page=dashboard";
    } else {
      alert("Veuillez choisir un travailleur !!!");
    }
  });

  // Afficher la fenetre modale
  attribuerTacheModalPopup.show();
}

// Modifier un element de la page de settings
function editElement(element, inputId, associatedId = null) {
  let elementToEdit = element.querySelector("#" + inputId);

  elementToEdit.disabled = elementToEdit.disabled === true ? false : true;

  if (associatedId) {
    let associateToEdit = document.querySelector("#" + associatedId);
    associateToEdit.disabled = !associateToEdit.disabled;
  }
}

// *********************************************************************************************************************************************************************
/**
 *  Fin Fonctions
 */
// *********************************************************************************************************************************************************************

// #######################################################################################################################################################################

/**
 *  Gestion des événements
 */

// ########################################################################################################################################################################

if (buttonAddTask) {
  buttonAddTask.addEventListener("click", addTask);
}
