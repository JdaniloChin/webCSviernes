document.addEventListener('DOMContentLoaded', function(){

    const tasks = [{
        id: 1,
        title: "Complete project report",
        description: "Prepare and submit the project report",
        dueDate: "2024-12-01"
    },
    {
        id:2,
        title: "Team Meeting",
        description: "Get ready for the season",
        dueDate: "2024-12-01"
    },
    {
        id: 3,
        title: "Code Review",
        description: "Check partners code",
        dueDate: "2024-12-01"
    }];
    
    function loadTasks(){
        const taskList = document.getElementById('task-list');
        taskList.innerHTML = '';
        tasks.forEach(function(task){
            const taskCard = document.createElement('div');
            taskCard.className = 'col-md-4 mb-3';
            taskCard.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${task.title}</h5>
                    <p class="card-text">${task.description}</p>
                    <p class="card-text"><small class="text-muted">Due: ${task.dueDate}</small> </p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button class="btn btn-secondary btn-sm edit-task" data-id="${task.id}">Edit</button>
                    <button class="btn btn-danger btn-sm delete-task" data-id="${task.id}">Delete</button>
                </div>
            </div>
            `;
            taskList.appendChild(taskCard);
        });

        document.querySelectorAll('.edit-task').forEach(function(button){
            button.addEventListener('click', handleEditTask);
        });

        document.querySelectorAll('.delete-task').forEach(function(button){
            button.addEventListener('click', handleDeleteTask);
        });
    }

    function handleEditTask(event){
        //abrir el modal y mostrar los datos
        alert(event.target.dataset.id);
    }


    function handleDeleteTask(event){
        alert(event.target.dataset.id);
    }

    document.getElementById('task-form').addEventListener('submit', function(e){
        e.preventDefault();
        alert("crear tarea");
        //TODO: 
        //1. obtener los datos de la tarea
        //2. agregar una tarea al array de tareas
        //3. llamar a load task

    });



    loadTasks();

});