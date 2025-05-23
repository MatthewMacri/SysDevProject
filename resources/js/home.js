// KANBAN BOARD INITIALIZATION
document.addEventListener("DOMContentLoaded", () => {
  fetch("../api/get_kanban_data.php")
    .then(res => res.json())
    .then(data => {
      // Initialize jKanban with data
      const board = new jKanban({
        element: "#kanban",
        gutter: "15px",
        widthBoard: "250px",
        responsivePercentage: false,
        dragItems: true,

        // Convert each status and its tasks into a board column
        boards: Object.entries(data).map(([status, items]) => ({
          id: status.replace(/\s/g, "_").toLowerCase(),
          title: `${status} (${items.length})`,
          class: "kanban-column",
          item: items.map(item => ({
            ...item,
            title: `${item.title} <button class='task-delete' style='float:right;border:none;background:none;cursor:pointer;'>🗑</button>`
          }))
        })),

        // Handle drag-and-drop updates
        dropEl: function (el, target) {
          const taskId = el.getAttribute("data-eid");
          const newStatus = target.parentElement.querySelector(".kanban-title-board").innerText.split(" (")[0];

          // Send updated status to server
          fetch("../api/update_task_status.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ task_id: taskId, new_status: newStatus })
          })
            .then(res => res.json())
            .then(response => {
              if (!response.success) alert("Failed to update task.");
            })
            .catch(err => {
              console.error("Update error:", err);
              alert("Error updating task.");
            });
        }
      });

      // Add task creation input ONLY under 'Prospecting'
      setTimeout(() => {
        document.querySelectorAll(".kanban-board").forEach(board => {
          const titleText = board.querySelector(".kanban-title-board").innerText;
          const status = titleText.split(" (")[0].trim();
          if (status.toLowerCase() !== "prospecting") return;
          
          const footer = document.createElement("div");
          footer.className = "kanban-footer";
          footer.innerHTML = `
            <input type="text" class="new-task-input" placeholder="New task" />
            <button class="add-task-btn"><i class="fa fa-plus"></i></button>
          `;
          board.appendChild(footer);

          const addBtn = footer.querySelector(".add-task-btn");
          const input = footer.querySelector(".new-task-input");

          // Handle add task button click
          addBtn.addEventListener("click", () => {
            const title = input.value.trim();
            if (!title) return;

            // Send new task to server with "Prospecting" as status
            fetch("../api/add_task.php", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ title, status: "Prospecting" })
            })
              .then(res => res.json())
              .then(data => {
                if (data.success) {
                  location.reload(); // Reload board to reflect changes
                } else {
                  alert("Error adding task.");
                }
              });
          });
        });
      }, 300);
    })
    .catch(err => console.error("Kanban load error:", err));
});

// TASK DELETION HANDLER
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("task-delete")) {
    const item = e.target.closest(".kanban-item");
    const taskId = item.getAttribute("data-eid");

    if (!confirm("Delete this task?")) return;

    // Send deletion request to server
    fetch("../api/delete_task.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ task_id: taskId.replace("task-", "") })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          item.remove(); // Remove task from DOM
        } else {
          alert("Failed to delete task.");
        }
      })
      .catch(err => {
        console.error("Delete error:", err);
        alert("Error deleting task.");
      });
  }
});

// FILTER TASKS BY KEYWORD
document.addEventListener("input", function (e) {
  if (e.target.id === "taskFilter") {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll(".kanban-item").forEach(item => {
      const text = item.textContent.toLowerCase();
      item.style.display = text.includes(search) ? "block" : "none";
    });
  }
});

// GANTT CHART INITIALIZATION
document.addEventListener("DOMContentLoaded", () => {
  fetch("../api/get_gantt_data.php")
    .then(res => res.json())
    .then(ganttData => {
      const ganttContainer = document.getElementById("gantt");
      if (ganttContainer) {
        $("#gantt").dxGantt({
          tasks: {
            dataSource: ganttData.tasks,
            keyExpr: "id",
            parentIdExpr: "parentId",
            titleExpr: "title",
            startExpr: "start",
            endExpr: "end"
          },
          dependencies: {
            dataSource: ganttData.dependencies || [],
            keyExpr: "id",
            predecessorIdExpr: "predecessorId",
            successorIdExpr: "successorId",
            typeExpr: "type"
          },
          editing: {
            enabled: false
          },
          validation: {
            autoUpdateParentTasks: true
          },
          height: 500,
          taskListWidth: 300
        });
      }
    })
    .catch(err => console.error("Failed to load Gantt data:", err));
});

// RECENT PROJECTS DISPLAY
document.addEventListener("DOMContentLoaded", () => {
  fetch("../api/get_recent_projects.php")
    .then(res => res.json())
    .then(projects => {
      const container = document.getElementById('recent-projects-container');
      if (!container) return;

      if (projects.length === 0 || projects.error) {
        container.innerHTML = "<p>No recent projects found.</p>";
        return;
      }

      // Render each project card
      projects.forEach(project => {
        const card = document.createElement("div");
        card.className = "project-card";

        card.innerHTML = `
          <span class="serial">${project.serial_number}</span>
          <span class="title">${project.project_name}</span>
          <span class="status">${project.status}</span>
          <p class="desc">${project.project_description}</p>
        `;

        container.appendChild(card);
      });
    })
    .catch(err => {
      console.error("Failed to load recent projects:", err);
    });
});