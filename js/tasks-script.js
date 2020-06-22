let taskList = document.querySelector('.task-list');
let deleteBtn = document.querySelectorAll('.btn-outline-danger');
let addBtn = document.querySelector('.add-form');

function deleteListener() {
  deleteBtn.forEach((item) => {
    let btns = item.parentElement;
    item.addEventListener('click', (e) => {
      e.preventDefault();
      let id = btns.getAttribute('task_id');
      fetch(`/tasks/${id}`, {
        method: 'DELETE',
      })
      .then(result => result.json())
      .then(res => {if(!res) alert('Failure deleting task')});

      let task = btns.parentElement;
      task.remove();
    });
  });
}

addBtn.addEventListener('submit', async (e) => {
  e.preventDefault();
  let textElem = document.querySelector('#txt');
  let textValue = textElem.value;
  let newTask = document.createElement("div");
  newTask.setAttribute('class', 'task');
  let taskHtml = `
    <div class="task-text">${textValue}</div>
    <div class="btns">
    <div class="btn-group-toggle done" data-toggle="buttons">
      <label class="btn btn-outline-success">
        <input type="checkbox" data-toggle="buttons"><i class="fa fa-check" aria-hidden="true"></i>
      </label>
    </div>
    <a href="#" class="btn btn-outline-warning" role="button" aria-pressed="true">
      <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
    <a href="#" class="btn btn-outline-danger" role="button" aria-pressed="true">
      <i class="fa fa-trash" aria-hidden="true"></i>
    </a>
    </div>
  `;
  taskList.append(newTask);
  newTask.innerHTML = taskHtml;
  textElem.value = '';
  let btns = newTask.querySelector('.btns');


  let rawResponse = await fetch(`/tasks`, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({text: textValue, status: ''})
  });
  const content = await rawResponse.json();
  const task_id = content.task_id;
  const user_id = content.user_id;

  btns.setAttribute('task_id', task_id);
  btns.setAttribute('user_id', user_id);
  deleteBtn = document.querySelectorAll('.btn-outline-danger');
  deleteListener();
  if(!content.task_id) alert('Failure adding task')
})


deleteListener();
