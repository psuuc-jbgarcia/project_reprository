function openModal() {
    let modal = document.getElementById("modal");
    let modalContent = document.getElementById("modal-content");
    modal.classList.remove("hidden");
    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
    }, 10);
}

function closeModal() {
    let modal = document.getElementById("modal");
    let modalContent = document.getElementById("modal-content");
    modalContent.classList.add("scale-95", "opacity-0");
    setTimeout(() => {
        modal.classList.add("hidden");
    }, 300);
}

document.getElementById("modal").addEventListener("click", function(event) {
    if (event.target === this) closeModal();
});

document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") closeModal();
});

function filterProjects() {
let input = document.getElementById("searchInput").value.toLowerCase();
let projects = document.querySelectorAll(".project-card > div"); // Select actual project cards

let anyVisible = false;

projects.forEach(project => {
let title = project.querySelector("h3").innerText.toLowerCase();
let description = project.querySelector("p").innerText.toLowerCase();

if (title.includes(input) || description.includes(input)) {
    project.style.display = "block"; // Show matching projects
    anyVisible = true;
} else {
    project.style.display = "none"; // Hide non-matching projects
}
});
}


setTimeout(function () {
let message = document.getElementById('success-message');
if (message) {
    message.style.transition = "opacity 0.5s";
    message.style.opacity = "0";
    setTimeout(() => message.remove(), 500);
}
}, 3000);

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
            editModal.classList.add('flex');
        })
        .catch(error => console.error("Error fetching project data:", error));
}

function closeEditModal() {
    const editModal = document.getElementById('editModal');
    editModal.classList.add('hidden');
    editModal.classList.remove('flex');
}
