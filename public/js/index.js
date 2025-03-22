 // Open Add Modal
 function openModal() {
    let modal = document.getElementById("modal");
    let modalContent = document.getElementById("modal-content");
    modal.classList.remove("hidden");
    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
    }, 10);
}

// Close Add Modal
function closeModal() {
    let modal = document.getElementById("modal");
    let modalContent = document.getElementById("modal-content");
    modalContent.classList.add("scale-95", "opacity-0");
    setTimeout(() => {
        modal.classList.add("hidden");
    }, 300);
}

// Filter Projects
function filterProjects() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let projects = document.querySelectorAll(".project-item");

    projects.forEach(project => {
        let title = project.querySelector("h3").innerText.toLowerCase();
        let description = project.querySelector("p").innerText.toLowerCase();

        if (title.includes(input) || description.includes(input)) {
            project.style.display = "block";
        } else {
            project.style.display = "none";
        }
    });
}

// Open Edit Modal
function openEditModal(projectId) {
    const editModal = document.getElementById('editModal');
    const editTitle = document.getElementById('edit_title');
    const editDescription = document.getElementById('edit_description');
    const editSource = document.getElementById('edit_source');
    const editProjectId = document.getElementById('edit_project_id');

    fetch(`/project/edit/${projectId}`)
        .then(response => response.json())
        .then(data => {
            editProjectId.value = data.id;
            editTitle.value = data.title;
            editDescription.value = data.description;
            editSource.value = data.source_code;

            editModal.classList.remove('hidden');
        })
        .catch(error => console.error("Error fetching project data:", error));
}

// Close Edit Modal
function closeEditModal() {
    const editModal = document.getElementById('editModal');
    editModal.classList.add('hidden');
}

// Auto-hide success message
setTimeout(function () {
    let message = document.getElementById('success-message');
    if (message) {
        message.style.transition = "opacity 0.5s";
        message.style.opacity = "0";
        setTimeout(() => message.remove(), 500);
    }
}, 3000);