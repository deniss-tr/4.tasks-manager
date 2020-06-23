let taskList = document.querySelector('.task-list');
let deleteBtn = document.querySelectorAll('.btn-outline-danger');
let doneBtns = document.querySelectorAll('.btn-outline-success');
let editBtns = document.querySelectorAll('.btn-outline-warning');
let addBtn = document.querySelector('.add-form');
let editSubmit = document.querySelectorAll('.edit-form');

function editTask(taskId, text, status = ''){
  fetch(`/tasks/${taskId}`, {
    method: 'PATCH',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({text: text, status: status})
  })
  .then(result => result.json())
  .then(res => {if(!res) alert('Failure changing status')});
}

function editSubmitListener(e){
  e.preventDefault();
  let task = this.closest('.task'),
    btns = task.querySelector('.btns'),
    textElem = task.querySelector('.task-text-inner'),
    taskText = textElem.textContent,
    taskTextInner = task.querySelector('.task-text-inner'),
    taskId = btns.getAttribute('task_id'),
    editBtn = btns.querySelector('.btn-outline-warning'),
    editFormDiv = task.querySelector('.edit-form-div');

  let inputText = task.querySelector('.edit-text-input');
  let text = inputText.value;

  editTask(taskId, text);
  taskTextInner.textContent = text;
  editBtn.classList.remove('active');
  taskTextInner.classList.remove('hide');
  editFormDiv.classList.add('hide');
}

editSubmit.forEach((editBtn) => {
  editBtn.addEventListener('submit', editSubmitListener);
});

function deleteListener(){
  let btns = this.parentElement;
  let id = btns.getAttribute('task_id');
  fetch(`/tasks/${id}`, {
    method: 'DELETE',
  })
  .then(result => result.json())
  .then(res => {if(!res) alert('Failure deleting task')});

  let task = btns.parentElement;
  task.remove();
}

function clickDelete() {
  deleteBtn.forEach((item) => {
    item.addEventListener('click', deleteListener);
  });
}
function doneListener(){

  let task = this.closest('.task');
  let btns = this.parentElement;
  let textElem = task.querySelector('.task-text');
  let taskText = textElem.textContent;
  let taskId = btns.getAttribute('task_id');


  if(!this.classList.contains("active")){

    textElem.className = 'task-text task-done';
    this.className = 'btn btn-outline-success active';

    editTask(taskId, taskText, 'task-done');

  } else {
    textElem.className = 'task-text';
    this.className = 'btn btn-outline-success';

    editTask(taskId, taskText, '');
  }
}
function clickDone() {
  doneBtns.forEach((btn) => {
    btn.addEventListener('click', doneListener);
  });
}

function editListener(){
  let task = this.closest('.task');
  let taskTextInner = task.querySelector('.task-text-inner');
  let editFormDiv = task.querySelector('.edit-form-div');
  let editForm = task.querySelector('.edit-form');

  if(this.classList.contains('active')){
    this.classList.remove('active');
    taskTextInner.classList.remove('hide');
    editFormDiv.classList.add('hide');
  } else {
    this.classList.add('active');
    taskTextInner.classList.add('hide');
    editFormDiv.classList.remove('hide');
  }
}
function clickEdit(){
  editBtns.forEach((btn) => {
    btn.addEventListener('click', editListener);
  });
}

addBtn.addEventListener('submit', async (e) => {
  e.preventDefault();
  let textElem = document.querySelector('#txt');
  let textValue = textElem.value;
  let newTask = document.createElement("div");
  newTask.setAttribute('class', 'task');
  let taskHtml = `
  <div class="task-text">
    <div class="task-text-inner">${textValue}</div>
    <div class="edit-form-div hide">
      <form class="edit-form"  method="post" action="/tasks">
        <input type="hidden" name="_METHOD" value="PATCH">
        <button type="submit" class="edit-btn"><i class="fa fa-check-circle"></i></button>
        <input type="text" value="${textValue}" class="edit-text-input" name='task-edit-text' required>
      </form>
    </div>
  </div>

  <div class="btns">
    <button type="button" class="btn btn-outline-success"><i class="fa fa-check" aria-hidden="true"></i></button>
    <button type="button" class="btn btn-outline-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>
    <button type="button" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
  </div>
  `;
  taskList.append(newTask);
  newTask.innerHTML = taskHtml;
  textElem.value = '';
  let btns = newTask.querySelector('.btns');
  let doneBtn = newTask.querySelector('.btn-outline-success');
  let deleteBtn = newTask.querySelector('.btn-outline-danger');
  let editBtn = newTask.querySelector('.btn-outline-warning');
  let editForm = newTask.querySelector('.edit-form');

  doneBtn.addEventListener('click', doneListener);
  deleteBtn.addEventListener('click', deleteListener);
  editBtn.addEventListener('click', editListener);
  editForm.addEventListener('submit', editSubmitListener);


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
  doneBtns = document.querySelectorAll('.btn-outline-success');

  if(!content.task_id) alert('Failure adding task');
})

clickDone();
clickDelete();
clickEdit();
