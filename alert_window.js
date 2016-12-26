window.alert=function(text, mtype) {
// устанавливаем сообщение
	$('._alert').html(text);
// указываем тип сообщения (стиль окна)
	$('._alert').attr("className", "_alert " + mtype);
// выводим окно
	$('#dialog').dialog({
	modal: true,
	width: 350,
	minHeight: 80,
	buttons: {
	"Закрыть": function() {
				$(this).dialog("close");
				}
	}
	});
}