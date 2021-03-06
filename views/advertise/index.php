<!DOCTYPE html>
<html>
	<head>
	<?include("../views/head.inc.php");?>
	<?include("../views/head_datatable.inc.php");?>
		
		<script type="text/javascript">
			$(function() {
				var dataTable = $('#advertise_data').DataTable({
                    language: {"url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Russian.json"},
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url:"/api/advertises",
                        type:"GET"
                    },
                    columns: [
                        { data: 'UserID' },
                        { data: 'Title' },
                        { data: 'Content' },
                        { data: 'DateTime' },
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
				
				$(document).on('submit', '#advertise_form', function(event){
					event.preventDefault();					
					
					var advertise_info = {
						"user_id":$("#user_id").val(),
						"title":$("#title").val(),
						"content":$("#content").val(),
						"datetime":$("#datetime").val()
					}
					
					var url="/api/advertises";
					if($("#operation").val()==1) {
						var ID = $("#advertise_ID").val();
						url+="/"+ID;						
					}					
					
					$.ajax({
                        url:url,
                        method: "POST",
                        data: JSON.stringify(advertise_info),
                        headers: {
                            "Content-type":"application/json"
                        },
                        success:function(data)
                        {									
                            $('#advertise_form')[0].reset();
                            $('#advertiseModal').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
				});
				
				$(document).on('click', '.update', function(event){
					//Режим редактирования (кнопка Редактировать)
					var ID = $(this).attr("ID");					
					
					$.ajax({
                        url:"/api/advertises/"+ID,
                        method:'GET',
                        dataType: "json",								
                        success:function(data)
                        {
                            //Заголовок окна
                            $('.modal-title').text("Редактировать рекламу");
                            
                            $("#user_id").val(data.UserID);
                            $("#title").val(data.Title);
                            $("#content").val(data.Content);
                            $('#advertise_ID').val(ID);									
                            
                            //Флаг операции (1 - редактирование)
                            $("#operation").val("1");
                            
                            //Текст на кнопке
                            $("#action").val("Сохранить изменения");
                            
                            //Отобразить форму
                            $('#advertiseModal').modal('show');									
                        }
                    });
					
					event.preventDefault();
				});
				
				$("#add_button").click(function() {
					//Режим добавления (кнопка Добавить)
									
					$("#user_id").val("");
                    $("#title").val("");
                    $("#content").val("");
                    $('#advertise_ID').val("");	
					
					//Заголовок окна
					$('.modal-title').text("Добавить рекламу");
					//Текст на кнопке
					$("#action").val("Добавить");
					//Флаг операции (0- добавление)
					$("#operation").val("0");
				});
				
				$(document).on("click",".delete",function() {
					//Режим удаления (кнопка Удалить)
					var advertise_ID = $(this).attr("ID");					
					
					if(confirm("Действительно удалить?"))
					{
						$.ajax({
							url:"/api/advertises/"+advertise_ID,
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
				
				$( "#advertise_form" ).validate({
					rules: {
						user_id: {
							required: true,							
							number: true,
							min: 0
						},
						title: "required",
						content: {
								required: true
						}
					},
					messages: {
						user_id:{ 
							required: "Пожалуйста укажите id",
							number: "id должен быть числом",
							min: "id не может быть меньше нуля"
						},
						title: {
							required: "Пожалуйста укажите заголовок"
						},
						content: { 
							required: "Пожалуйста укажите описание"
						}
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "invalid-feedback" );
						if ( element.prop( "type" ) === "checkbox" ) {
							error.insertAfter( element.parent( "label" ) );
						} else {
							error.insertAfter( element );
						}
					},
					highlight: function ( element, errorClass, validClass ) {
						$( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
					},
					unhighlight: function (element, errorClass, validClass) {
						$( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
					}
				});
				$('#advertiseModal').on('hidden.bs.modal',function(){
					//Очистка полей формы
					$(".form-control").val("");
					$( "#advertiseModal .field input" ).removeClass( "is-valid" ).removeClass( "is-invalid" );
					$(this).find("em").remove();
				});
			});
		</script>
	</head>
	<body>
		<?include("../views/user_menu.inc.php");?>
		<div class="container box">
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#advertiseModal" class="btn btn-info btn-lg">Добавить</button>
				</div>
				<br /><br />
				<table id="advertise_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">Пользователь</th>
							<th width="10%">Заголовок</th>
							<th width="10%">Описание</th>
							<th width="10%">Дата публикации</th>
							<th width="10%"></th>
							<th width="10%"></th>
						</tr>
					</thead>
				</table>				
			</div>
		</div>
		
		<div id="advertiseModal" class="modal fade">
			<div class="modal-dialog">
				<form method="post" id="advertise_form" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Добавить товар</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="field">
								<label>Пользователь</label>
								<input type="text" name="user_id" id="user_id" class="form-control" />
							</div>
							<div class="field">
								<label>Заголовок</label>
								<input type="text" name="title" id="title" class="form-control" />
							</div>
							<div class="field">
								<label>Описание</label>
								<input type="text" name="content" id="content" class="form-control" />
							</div>
							
						</div>
						<div class="modal-footer">
							<input type="hidden" name="advertise_ID" id="advertise_ID" />
							<input type="hidden" name="operation" id="operation" />
							<input type="submit" name="action" id="action" class="btn btn-success" value="Добавить" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?include("../views/footer.inc.php");?>
	</body>
</html>
