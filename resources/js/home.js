//Gantt chart
$(() => {
  $("#gantt").dxGantt({
    rootValue: 0,
    tasks: {
      dataSource: tasks,
    },
    dependencies: {
      dataSource: dependencies,
    },
    resources: {
      dataSource: resources,
    },
    resourceAssignments: {
      dataSource: resourceAssignments,
    },
    editing: {
      enabled: false,
    },
    validation: {
      autoUpdateParentTasks: true,
    },
    toolbar: {
      items: [
        "undo",
        "redo",
        "separator",
        "collapseAll",
        "expandAll",
        "separator",
        "addTask",
        "deleteTask",
        "separator",
        "zoomIn",
        "zoomOut",
      ],
    },
    columns: [
      {
        dataField: "title",
        caption: "Subject",
        width: 300,
      },
      {
        dataField: "start",
        caption: "Start Date",
      },
      {
        dataField: "end",
        caption: "End Date",
      },
    ],
    scaleType: "weeks",
    taskListWidth: 500,
  });
});

// Kanban chart
$(() => {
  new jKanban({
    element: "#kanban",
    dragItems: false,
    boards: [
      {
        id: "_prospecting",
        title: "Prospecting",
        class: "info",
        item: [{ title: "Design Login Page" }, { title: "Connect to API" }],
      },
      {
        id: "_todo",
        title: "To Do",
        class: "info",
        item: [{ title: "Design Login Page" }, { title: "Connect to API" }],
      },
      {
        id: "_inprogress",
        title: "In Progress",
        class: "warning",
        item: [{ title: "Fix Gantt Chart Display" }],
      },
      {
        id: "_done",
        title: "Done",
        class: "success",
        item: [{ title: "Create Task Dataset" }],
      },
    ],
  });
});

//render recent projects

$( () => {
  const container = document.getElementById('recent-projects-container');

  recentProjects.forEach(project => {
    const card = document.createElement('div');
    card.className = 'project-card';

    card.innerHTML = `
      <span class="serial">${project.serial}</span>
      <span class="title">${project.title}</span>
      <span class="status">${project.status}</span>
      <p class="desc">${project.description}</p>
    `;

    container.appendChild(card);
  });
});
