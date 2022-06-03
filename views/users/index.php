<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.6.0/dt-1.12.1/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.6.0/dt-1.12.1/datatables.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/scripts/jquery-validation/src/additional/pattern.js"></script>

		
		<script type="text/javascript">
			$(function() {
				var dataTable = $('#user_data').DataTable({
                    language: {"url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Russian.json"},
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
                                    + data + '" class="btn btn-warning btn-sm update">Редактировать</button>';
                            }
                        },
                        {
                            data: 'ID',
                            render: function(data, type) {
                                return '<button type="button" name="delete" id="'
                                    + data + '" class="btn btn-danger btn-sm delete">Удалить</button>';
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
						"username":$("#username").val(),
						"login":$("#login").val(),
						"password":$("#password").val(),
						"roleid":$("#roleid").val(),
						"state":$("#state").val()
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
                            
                            $("#username").val(data.UserName);
                            $("#login").val(data.Login);
							$("#password").val("");
                            $("#roleid").val(data.RoleID);
                            $("#state").val(data.State);
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
									
					$("#username").val("");
					$("#login").val("");
					$("#password").val("");
					$("#roleid").val("");
					$("#state").val("");
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
						username: "required",
						login: "required",
						roleid: {
							required: true,
							number: true,
							min: 1,
							max: 4
						},
						state: {
							required: true,
							number: true,
						},
					},
					messages: {
						username: "Пожалуйста укажите ФИО пользователя",
						login: "Пожалуйста укажите логин пользователя",
						password: "Пожалуйста, укажите пароль пользователя",
						roleid: {
							required: "Пожалуйста укажите номер роли пользователя",
							number: "Номер роли должен быть числом",
							min: "Номер роли должен быть 1 или более",
							max: "Номер роли должен быть 4 или менее"						
						},
						state: {
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
		<?include("../user_menu.inc");?>
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
							<h4 class="modal-title">Добавить пользователя</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="field">
								<label>ФИО пользователя</label>
								<input type="text" name="username" id="username" class="form-control" />
							</div>
							<div class="field">
								<label>Логин</label>
								<input type="text" name="login" id="login" class="form-control" />
							</div>
							<div class="field">
								<label>Пароль</label>
								<input type="text" name="password" id="password" class="form-control" />
							</div>
							<div class="field">
								<label>Номер роли</label>
								<input type="text" name="roleid" id="roleid" class="form-control" />
							</div>
							<div class="field">
								<label>Состояние</label>
								<input type="text" name="state" id="state" class="form-control" />
							</div>
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
