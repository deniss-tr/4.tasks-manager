let back = "<button class='btn btn-warning modal-btn' data-dismiss='modal'>Back</button>";
$('#statusModal').on('show.bs.modal', function (event) {
  let login = $(event.relatedTarget).parent().siblings('.td-login').contents().text();
  let id = $(event.relatedTarget).parent().siblings('.td-id').contents().text();
  let status = $(event.relatedTarget).contents().text();
  let txt = 'init';
  let modal = $(this);
  let myId = document.querySelector('#user-id').textContent;
  let changeForm = `
  <form method='post' action='/admin/${id}'>
	<input type="hidden" name="_METHOD" value="PATCH">
	<button type='submit' class='btn btn-success modal-btn'>Change</button>
  </form>`;
  if(status == 'admin'){
	if(id == 1){
		txt = "You can't change status for root admin";
		modal.find('.modal-btn').replaceWith(back);
	} else if (id == myId) {
		txt = "You can't change status for yourself";
		modal.find('.modal-btn').replaceWith(back);
	}
	else {
		txt = "Status will be changed from ADMIN to USER for " + login;
		modal.find('.modal-btn').replaceWith(changeForm);
	}
	} else {
		txt = "Status will be changed from USER to ADMIN for " + login;
		modal.find('.modal-btn').replaceWith(changeForm);
	}
	modal.find('.modal-body').text(txt);
  
});

$('#deleteModal').on('show.bs.modal', function (event) {
  let login = $(event.relatedTarget).parent().siblings('.td-login').contents().text();
  let id = $(event.relatedTarget).parent().siblings('.td-id').contents().text();
  let status = $(event.relatedTarget).parent().siblings('.td-status').contents().text();
  let txt = "Are you sure you want to delete: " + login;
  let modal = $(this);
  let delForm = `
  <form method='post' action='/admin/${id}'>
	<input type="hidden" name="_METHOD" value="DELETE">
	<button type='submit' class='btn btn-danger modal-btn'>Delete</button>
  </form>`;
  if(status == 'admin'){
	  txt = "you can't delete admin";
	  modal.find('.modal-btn').replaceWith(back);
  } else {
	modal.find('.modal-btn').replaceWith(delForm);
  }
  modal.find('.modal-body').text(txt);
  
});

(function () {
  'use strict'
  feather.replace()

}())
