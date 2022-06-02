<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/scripts/jquery-validation/src/additional/pattern.js"></script>
		
		<script type="text/javascript">
			$(function() {
				var dataTable = $('#user_data').DataTable({
                    language: {"url":"http://cdn.datatables.net/plug-ins/1.10.20/i18n/Russian.json"},
                    processing: true,
                    serverSide: true,
                    order: [],
					ajax: {
                        url:"/api/users",
                        type:"GET"
                    },
                    columns: [
                        { data: 'UserName' },
                        { data: 'Login' },
                        { data: 'RoleName' },
                        { data: 'State' },
                        {
                            data: 'ID',
                            render: function(data, type) {
                                return '<button type="button" name="update" id="'
                                    + data + '" class="btn btn-warning btn-xs update">Редактировать</button>';
                            }
                        },
                        {
                            data: 'ID',
                            render: function(data, type) {
                                return '<button type="button" name="delete" id="'
                                    + data + '" class="btn btn-danger btn-xs delete">Удалить</button>';
                            }
                        },
                    ],
                    columnDefs: [
                        {
                            "targets": [4, 5], // Столбцы, по которым не нужна сортировка
                            "orderable": false,
                        },
                    ],
				});	
				
				$(document).on('submit', '#user_form', function(event){
					event.preventDefault();					
					
					var user_info = {
						"UserName":$("#UserName").val(),
						"Login":$("#Login").val(),
						"Password":$("#Password").val(),
						"RoleID":$("#RoleID").val(),
						"State":$("#State").val()
					}
					
					var url="/api/users";
					//redactirov
					if($("#operation").val()==1) {
						var ID = $("#user_ID").val();
						url+="/"+ID;						
					}				
					
					$.ajax({
                        url:url,
                        method: "POST",
                        data: JSON.stringify(user_info),
                        headers: {
                            "Content-type":"application/json"
                        },
                        success:function(data)
                        {									
                            $('#user_form')[0].reset();
                            $('#userModal').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
				});
				
				$(document).on('click', '.update', function(event){
					//Режим редактирования (кнопка Редактировать)
					var ID = $(this).attr("ID");					
					
					$.ajax({
                        url:"/api/users/"+ID,
                        method:'GET',
                        dataType: "json",								
                        success:function(data)
                        {
                            //Заголовок окна
                            $('.modal-title').text("Редактировать пользователя");
                            
                            $("#UserName").val(data.UserName);
                            $("#Login").val(data.Login);
							$("#Password").val("");
                            $("#RoleID").val(data.RoleID);
                            $("#State").val(data.State);
                            $('#user_ID').val(ID);									
                            
                            //Флаг операции (1 - редактирование)
                            $("#operation").val("1");
                            
                            //Текст на кнопке
                            $("#action").val("Сохранить изменения");
                            
                            //Отобразить форму
                            $('#userModal').modal('show');									
                        }
                    });
					
					event.preventDefault();
				});
				
				$("#add_button").click(function() {
					//Режим добавления (кнопка Добавить)
									
					$("#UserName").val("");
					$("#Login").val("");
					$("#Password").val("");
					$("#RoleID").val("");
					$("#State").val("");
					$('#user_ID').val("");

					//Заголовок окна
					$('.modal-title').text("Добавить пользователя");
					//Текст на кнопке
					$("#action").val("Добавить");
					//Флаг операции (0- добавление)
					$("#operation").val("0");
				});
				
				$(document).on("click",".delete",function() {
					//Режим удаления (кнопка Удалить)
					var user_ID = $(this).attr("ID");					
					
					if(confirm("Действительно удалить?"))
					{
						$.ajax({
							url:"/api/users/"+user_ID,
							method:"DELETE",							
							success:function(data)
							{								
								dataTable.ajax.reload();
							}
						});
					}
					else
					{
						return false;	
					}
				});
				
				$( "#user_form" ).validate({
					rules: {
						UserName: "required",
						Login: "required",
						RoleID: {
							required: true,
							number: true,
							min: 1,
							max: 4
						},
						State: {
							required: true,
							number: true,
						},
					},
					messages: {
						UserName: "Пожалуйста укажите ФИО пользователя",
						Login: "Пожалуйста укажите логин пользователя",
						Password: "Пожалуйста, укажите пароль пользователя",
						RoleID: {
							required: "Пожалуйста укажите номер роли пользователя",
							number: "Номер роли должен быть числом",
							min: "Номер роли должен быть 1 или более",
							max: "Номер роли должен быть 4 или менее"						
						},
						State: {
							required: "Пожалуйста укажите состояние пользователя",
							number: "Состояние пользователя должно быть числом"
						},
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "help-block" );
						if ( element.prop( "type" ) === "checkbox" ) {
							error.insertAfter( element.parent( "label" ) );
						} else {
							error.insertAfter( element );
						}
					},
					highlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".field" ).addClass( "has-error" ).removeClass( "has-success" );
					},
					unhighlight: function (element, errorClass, validClass) {
						$( element ).parents( ".field" ).addClass( "has-success" ).removeClass( "has-error" );
					}
				});
				$('#userModal').on('hidden.bs.modal',function(){
					//Очистка полей формы
					$(".form-control").val("");
					$( "#userModal .field" ).removeClass( "has-success" ).removeClass( "has-error" );
					$(this).find("em").remove();
				});
			});
		</script>
	</head>
	<body>
		<div class="container box">
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Добавить</button>
				</div>
				<br /><br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">ФИО пользователя</th>
							<th width="10%">Логин</th>
							<th width="10%">Роль</th>
							<th width="10%">Состояние</th>
							<th width="10%"></th>
							<th width="10%"></th>
						</tr>
					</thead>
				</table>				
			</div>
		</div>
		
		<div id="userModal" class="modal fade">
			<div class="modal-dialog">
				<form method="post" id="user_form" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Добавить пользователя</h4>
						</div>
						<div class="modal-body">
							<div class="field">
								<label>ФИО пользователя</label>
								<input type="text" name="UserName" id="UserName" class="form-control" />
							</div>
							<div class="field">
								<label>Логин</label>
								<input type="text" name="Login" id="Login" class="form-control" />
							</div>
							<div class="field">
								<label>Пароль</label>
								<input type="text" name="Password" id="Password" class="form-control" />
							</div>
							<div class="field">
								<label>Номер роли</label>
								<input type="text" name="RoleID" id="RoleID" class="form-control" />
							</div>
							<div class="field">
								<label>Состояние</label>
								<input type="text" name="State" id="State" class="form-control" />
							</div>
							<!-- <div class="field">
								<label>Страна</label>
								<input type="text" name="Strana" id="Strana" class="form-control" />
							</div>
							<div class="field">
								<label>Описание</label>
								<input type="text" name="Opisanie" id="Opisanie" class="form-control" />
							</div> -->
							<!--br />
							<label>Select User Image</label>
							<input type="file" name="user_image" id="user_image" />
							<span id="user_uploaded_image"></span-->
						</div>
						<div class="modal-footer">
							<input type="hidden" name="user_ID" id="user_ID" />
							<input type="hidden" name="operation" id="operation" />
							<input type="submit" name="action" id="action" class="btn btn-success" value="Добавить" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
