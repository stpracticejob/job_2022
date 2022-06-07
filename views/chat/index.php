<!DOCTYPE html>
<html>
	<head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <?php include("../views/head_datatable.inc");?>
	</head>
	<body>
    <?php include("../views/user_menu.inc");?>
    <?php include("../views/chat/style.inc");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="modal fade" id="newChatModal" tabindex="-1" role="dialog" aria-labelledby="newChatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newChatModalLabel">Новое сообщение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="new_chat_login" class="col-form-label">Получатель:</label>
                            <input type="text" class="form-control" id="new_chat_login">
                        </div>
                        <div class="form-group">
                            <label for="new_chat_message" class="col-form-label">Сообщение:</label>
                            <textarea class="form-control" id="new_chat_message"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="new-chat-send">Отправить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg spin-modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 48px">
                <span class="fa fa-spinner fa-spin fa-3x"></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <ul class="list-unstyled chat-list mt-2 mb-0"></ul>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newChatModal">
                            Написать новому пользователю
                        </button>
                    </div>
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0 chat-about-desc"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0 messageWithUser"><div class="center">Выберите чат!</div></ul>
                        </div>
                        <div class="chat-message clearfix">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" ><i style="font-size: 2rem; color: #1d8ecd " class="fa fa-send"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Введите текст...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("../views/chat/scripts.inc");?>
    <?php include('../views/footer.inc'); ?>
	</body>
</html>
