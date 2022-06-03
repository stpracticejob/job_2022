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
				var dataTable = $('#tovar_data').DataTable({
                    language: {"url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Russian.json"},
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url:"/api/cv",
                        type:"GET"
                    },
                    columns: [
                        { data: 'UserName' },
                        { data: 'SectionName' },
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
                            "targets": [5, 6], // Столбцы, по которым не нужна сортировка
                            "orderable": false,
                        },
                    ],
				});

				$(document).on('submit', '#tovar_form', function(event){
					event.preventDefault();

					var tovar_info = {
						"UserName":$("#Nazvanie").val(),
						"SectionName":$("#SectionName").val(),
						"Title":$("#Title").val(),
						"Content":$("#Content").val(),
						"DateTime":$("#DateTime").val()
					}

					var method="PUT";
					if($("#tovarModal #operation").val()==1) {
						method="PATCH";
						tovar_info.ID = $("#cv_ID").val();
					}

					$.ajax({
                        url:"/api/cv",
                        method: method,
                        data: JSON.stringify(tovar_info),
                        headers: {
                            "Content-type":"application/json"
                        },
                        success:function(data)
                        {
                            $('#tovar_form')[0].reset();
                            $('#tovarModal').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
				});

				$(document).on('click', '.update', function(event){
					//Режим редактирования (кнопка Редактировать)
					var ID = $(this).attr("ID");

					$.ajax({
                        url:"/api/cv/"+ID,
                        method:'GET',
                        dataType: "json",
                        success:function(data)
                        {
                            //Заголовок окна
                            $('.modal-title').text("Редактировать товар");

                            $("#tovarModal #Nazvanie").val(data.Nazvanie);
                            $("#tovarModal #Cena").val(data.Cena);
                            $("#tovarModal #Kol").val(data.Kol);
                            $("#tovarModal #God").val(data.God);
                            $("#tovarModal #Strana").val(data.Strana);
                            $("#tovarModal #Opisanie").val(data.Opisanie);
                            $('#tovarModal #tovar_ID').val(ID);

                            //Флаг операции (1 - редактирование)
                            $("#tovarModal #operation").val("1");

                            //Текст на кнопке
                            $("#tovarModal #action").val("Сохранить изменения");

                            //Отобразить форму
                            $('#tovarModal').modal('show');
                        }
                    });

					event.preventDefault();
				});

				$("#add_button").click(function() {
					//Режим добавления (кнопка Добавить)

					$("#tovarModal #Nazvanie").val("");
					$("#tovarModal #Cena").val("");
					$("#tovarModal #Kol").val("");
					$("#tovarModal #God").val("");
					$("#tovarModal #Strana").val("");
					$("#tovarModal #Opisanie").val("");
					$('#tovarModal #tovar_ID').val("");

					//Заголовок окна
					$('.modal-title').text("Добавить товар");
					//Текст на кнопке
					$("#tovarModal #action").val("Добавить");
					//Флаг операции (0- добавление)
					$("#tovarModal #operation").val("0");
				});

				$(document).on("click",".delete",function() {
					//Режим удаления (кнопка Удалить)
					var tovar_ID = $(this).attr("ID");

					if(confirm("Действительно удалить?"))
					{
						$.ajax({
							url:"/rest/tovar?ID="+tovar_ID,
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

				$( "#tovar_form" ).validate({
					rules: {
						Nazvanie: "required",
						Cena: {
							required: true,
							number: true,
							min: 0
						},
						Kol: {
							required: true,
							number: true,
							min: 1
						},
						God: {
							required: true,
							number: true,
							min: 1900,
							max: new Date().getFullYear()
						},
						Strana: {
							required: true,
							number: true,
							min: 1,
						},
						Opisanie: "required"
					},
					messages: {
						Nazvanie: "Пожалуйста укажите ваше имя",
						Cena: {
							required: "Пожалуйста укажите цену",
							number: "Цена должна быть числом",
							min: "Цена не может быть меньше нуля"
						},
						Kol: {
							required: "Пожалуйста укажите количество",
							number: "Количество должно быть числом",
							min: "Количество должно быть 1 или более"
						},
						God: {
							required: "Пожалуйста укажите год",
							number: "Год должен быть числом",
							min: "Год должен быть не ранее 1900",
							max: "Год не может быть больше текущего"
						},
						Strana: {
							required: "Пожалуйста укажите страну",
							number: "Страна должна быть числом",
							min: "Страна должна быть 1 или более"
						},
						Opisanie: "Пожалуйста укажите описание"
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

				$('#tovarModal').on('hidden.bs.modal',function(){
					//Очистка полей формы
					$(".form-control").val("");
					$( "#tovarModal .field" ).removeClass( "has-success" ).removeClass( "has-error" );
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
					<button type="button" id="add_button" data-toggle="modal" data-target="#tovarModal" class="btn btn-info btn-lg">Добавить</button>
				</div>
				<br /><br />
				<table id="tovar_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">Категория</th>
							<th width="10%">Пользователь</th>
							<th width="10%">Заголовок</th>
							<th width="10%">Описание</th>
							<th width="10%">Дата</th>
							<th width="10%"></th>
							<th width="10%"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

		<div id="tovarModal" class="modal fade">
			<div class="modal-dialog">
				<form method="post" id="tovar_form" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Добавить товар</h4>
						</div>
						<div class="modal-body">
							<div class="field">
								<label>Название</label>
								<input type="text" name="Nazvanie" id="Nazvanie" class="form-control" />
							</div>
							<div class="field">
								<label>Цена</label>
								<input type="text" name="Cena" id="Cena" class="form-control" />
							</div>
							<div class="field">
								<label>Количество</label>
								<input type="text" name="Kol" id="Kol" class="form-control" />
							</div>
							<div class="field">
								<label>Год</label>
								<input type="text" name="God" id="God" class="form-control" />
							</div>
							<div class="field">
								<label>Страна</label>
								<input type="text" name="Strana" id="Strana" class="form-control" />
							</div>
							<div class="field">
								<label>Описание</label>
								<input type="text" name="Opisanie" id="Opisanie" class="form-control" />
							</div>
							<!--br />
							<label>Select User Image</label>
							<input type="file" name="user_image" id="user_image" />
							<span id="user_uploaded_image"></span-->
						</div>
						<div class="modal-footer">
							<input type="hidden" name="tovar_ID" id="tovar_ID" />
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
