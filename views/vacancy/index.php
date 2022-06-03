<!DOCTYPE html>
<html>
	<head>
		<?include("../views/head.inc");?>
		<?include("../views/head_datatable.inc");?>

		<script type="text/javascript">
			$(function() {
				var dataTable = $('#vacancy_data').DataTable({
                    language: {"url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Russian.json"},
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url:"/api/vacancy",
                        type:"GET"
                    },
                    columns: [
					    { data: 'ID' },
						{ data: 'UserLogin' },
                        { data: 'SectionName' },
                        { data: 'Title' },
                        { data: 'Content' },
						{ data: 'Salary' },
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
                            "targets": [6, 7], // Столбцы, по которым не нужна сортировка
                            "orderable": false,
                        },
                    ],
				});

				$(document).on('submit', '#vacancy_form', function(event){
					event.preventDefault();

					var vacancy_info = {
						"user_id":$("#user_id").val(),
						"section_id":$("#section_id").val(),
						"title":$("#title").val(),
						"content":$("#content").val(),
						"salary":$("#salary").val(),
						"experience":$("#experience").val(),
						"is_main":$("#is_main").val(),
						"is_partnership":$("#is_partnership").val(),
						"is_remote":$("#is_remote").val()
					}

					var url="/api/vacancy";

					//Флаг операции (1 - редактирование)
					if($("#operation").val()==1) {
						var ID = $("#vacancy_ID").val();
						url+="/"+ID;
					}

					$.ajax({
                        url:url,
                        method: "POST",
                        data: JSON.stringify(vacancy_info),
                        headers: {
                            "Content-type":"application/json"
                        },
                        success:function(data)
                        {
                            $('#vacancy_form')[0].reset();
                            $('#vacancyModal').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
				});

				$(document).on('click', '.update', function(event){
					//Режим редактирования (кнопка Редактировать)
					var ID = $(this).attr("ID");

					$.ajax({
                        url:"/api/vacancy/"+ID,
                        method:'GET',
                        dataType: "json",
                        success:function(data)
                        {
                            //Заголовок окна
                            $('.modal-title').text("Редактировать Вакансию");

                            $("#user_id").val(data.UserID);
                            $("#vacancyModal #section_id").val(data.SectionID);
                            $("#vacancyModal #title").val(data.Title);
                            $("#vacancyModal #content").val(data.Content);
                            $("#vacancyModal #salary").val(data.Salary);
                            $("#vacancyModal #experience").val(data.Experience);
							$("#vacancyModal #is_main").val(data.IsMain);
							$("#vacancyModal #is_partnership").val(data.IsPartnership);
							$("#vacancyModal #is_remote").val(data.IsRemote);
                            $('#vacancyModal #vacancy_ID').val(ID);

                            //Флаг операции (1 - редактирование)
                            $("#vacancyModal #operation").val("1");

                            //Текст на кнопке
                            $("#vacancyModal #action").val("Сохранить изменения");

                            //Отобразить форму
                            $('#vacancyModal').modal('show');
                        }
                    });

					event.preventDefault();
				});

				$("#add_button").click(function() {
					//Режим добавления (кнопка Добавить)

					$("#vacancyModal #user_id").val("");
					$("#vacancyModal #section_id").val("");
					$("#vacancyModal #title").val("");
					$("#vacancyModal #content").val("");
					$("#vacancyModal #salary").val("");
					$("#vacancyModal #experience").val("");
					$("#vacancyModal #is_main").val("");
					$("#vacancyModal #is_partnership").val("");
					$("#vacancyModal #is_remote").val("");
					$('#vacancyModal #vacancy_ID').val("");

					//Заголовок окна
					$('.modal-title').text("Добавить Вакансию");
					//Текст на кнопке
					$("#vacancyModal #action").val("Добавить");
					//Флаг операции (0- добавление)
					$("#vacancyModal #operation").val("0");
				});

				$(document).on("click",".delete",function() {
					//Режим удаления (кнопка Удалить)
					var vacancy_ID = $(this).attr("ID");

					if(confirm("Действительно удалить?"))
					{
						$.ajax({
							url:"/api/vacancy/"+vacancy_ID,
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

				$( "#vacancy_form" ).validate({
					rules: {
						user_id: "required",
						section_id: "required",
						title: "required",
						content: "required",

						salary: {
							required: true,
							number: true,
							min: 0,
							max: 500000
						},
						experience: {
							required: true,
							number: true,
							min: 0,
							max: 80
						},
						is_main: {
							required: true,
							number: true,
							min: 0,
							max: 1
						},
						is_partnership: {
							required: true,
							number: true,
							min: 0,
							max: 1
						},
						is_remote: {
							required: true,
							number: true,
							min: 0,
							max: 1
						},

					},
					messages: {
						user_id: "Пожалуйста, укажите Ваш ID",
						section_id: "Пожалуйста, укажите ID Категории",
						title: "Пожалуйста, укажите должность",
						content: "Пожалуйста, добавьте описание",
						salary: {
							required: "Пожалуйста, укажите Заработную Плату",
							number: "Используйте числа",
							min: "Зарплата не может быть отрицательной",
							max: "Зарплата не может быть выше 500 000 руб."
						},
						experience: {
							required: "Пожалуйста, укажите требуемый Опыт Работы в годах",
							number: "Запишите числом",
							min: "Опыт не может быть отрицательным",
							max: "Нам не нужно такое Божество"
						},
						is_main: {
							required: "Пожалуйста, укажите возможность официального трудоустройства",
							number: "Запишите числом",
							min: "Разрешены значения только 0 и 1",
							max: "Разрешены значения только 0 и 1"
						},
						is_partnership: {
							required: "Пожалуйста, укажите возможность заключить краткосрочный контракт",
							number: "Запишите числом",
							min: "Разрешены значения только 0 и 1",
							max: "Разрешены значения только 0 и 1"
						},
						is_remote: {
							required: "Пожалуйста укажите возможность удаленной работы",
							number: "Запишите числом",
							min: "Разрешены значения только 0 и 1",
							max: "Разрешены значения только 0 и 1"
						},
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

				$('#vacancyModal').on('hidden.bs.modal',function(){
					//Очистка полей формы
					$(".form-control").val("");
					$( "#vacancyModal .field input" ).removeClass( "is-valid" ).removeClass( "is-invalid" );
					$(this).find("em").remove();
				});
			});
		</script>
	</head>
	<body>
		<?include("../views/user_menu.inc");?>
		<div class="container box">
			<div align="right">
				<button type="button" id="add_button" data-toggle="modal" data-target="#vacancyModal" class="btn btn-info btn-lg">Добавить</button>
			</div>
			<div class="table-responsive">
				<br />
				<br /><br />
				<table id="vacancy_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">ID</th>
							<th width="10%">E-mail нанимателя</th>
							<th width="10%">Категория</th>
							<th width="10%">Должность</th>
							<th width="10%">Описание</th>
							<th width="10%">Зарплата</th>
							<th width="10%"></th>
							<th width="10%"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

		<div id="vacancyModal" class="modal fade">
			<div class="modal-dialog">
				<form method="post" id="vacancy_form" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
                        <h4 class="modal-title">Добавить Вакансию</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="field">
								<label>ID нанимателя</label>
								<input type="text" name="user_id" id="user_id" class="form-control" />
							</div>

							<div class="field">
								<label>ID Категории</label>
								<input type="text" name="section_id" id="section_id" class="form-control" />
							</div>
							<div class="field">
								<label>Должность</label>
								<input type="text" name="title" id="title" class="form-control" />
							</div>
							<div class="field">
								<label>Описание</label>
								<input type="text" name="content" id="content" class="form-control" />
							</div>
							<div class="field">
								<label>Зарплата</label>
								<input type="text" name="salary" id="salary" class="form-control" />
							</div>
							<div class="field">
								<label>Требуемый опыт работы</label>
								<input type="text" name="experience" id="experience" class="form-control" />
							</div>
							<div class="field">
								<label>Официальное трудоустройство в штат</label>
								<input type="text" name="is_main" id="is_main" class="form-control" />
							</div>
							<div class="field">
								<label>Возможность оформить договор подряда</label>
								<input type="text" name="is_partnership" id="is_partnership" class="form-control" />
							</div>
							<div class="field">
								<label>Возможность удаленной работы</label>
								<input type="text" name="is_remote" id="is_remote" class="form-control" />
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="vacancy_ID" id="vacancy_ID" />
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
