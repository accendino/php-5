<?php 

print_r($_POST);
echo "<br>";

$adminEmail = "mail2olya@mailru";
$emailSubject = "Сообщение с сайта";
$errors = array();

if (array_key_exists('sendForm', $_POST)) { //если присутствует указанный ключ в массиве $_POST, то выполняем следующее..
	//проверяем поля на заполненность, если пустые, формируем массив с ошибками и вывести его, если ошибок нет - будем сохранять данные в БД
	//обработка ошибок, если поля не заполнены - записываем в массив с ошибками
	if ($_POST['userName'] == '') {
		$errors[] = "Укажите свое имя.";
	}
	if ($_POST['userEmail'] == '') {
		$errors[] = "Укажите свой email.";
		
	}
	if ($_POST['message'] == '') {
		$errors[] = "Введите сообщение.";
	}
}
	
if (!empty($_POST)) {  //проверяем, если массив не пуст, то формируем сообщение
	$timetag = getdate();

	$headersEmail = 'Time: ' . $timetag["mday"] . "/" . $timetag["month"] . "/" . $timetag["year"] . ", " . $timetag["hours"] . ":" . $timetag["minutes"] . "\r\n" .          'From: ' . $_POST['userName'] . ' <' . $_POST['userEmail'] . '>' . "\r\n" . 'Reply-To: ' . $_POST['userEmail'] . "\r\n";	

	$message = "Вам поступило сообщение с сайта site@domain.ru (" . $timetag["mday"] . "/" . $timetag["month"] . "/" . $timetag["year"] . ", " . $timetag["hours"] . ":" . $timetag["minutes"] . ")" . ": \n" 
	. "Имя отправителя: " . $_POST['userName'] . "\n"
	. "Email отправителя: " . $_POST['userEmail'] . "\n" 
	. "Сообщение: \n" . $_POST['message'];

	// для отправки email используем функцию mail(), также, эта функция вернет нам bool, запишем результат в переменную
	$mailResult = mail($adminEmail, $emailSubject, $message, $headersEmail);

	if ($mailResult && empty($errors)) {
		//header("location: thankyou.html ");
		echo "<h1 style='color:green;'>Сообщение успешно отправлено!</h1>";
	} else {
		echo "<h1 style='color:red;'>Что-то пошло не так!</h1>";
		$length = count($errors);
		for ($i=0; $i < $length; $i++) {
			echo "<h3 style='color:red;'>$errors[$i]</h3>";
		}
	}
}

?>

<h1>Форма обратной связи</h1>
    <form action="index.php" method="post" > <!-- index.html -->
	    <input type="text" name="userName" placeholder="Введите имя"><br>
	    <input type="text" name="userEmail" placeholder="Введите Email"><br>
	    <textarea name="message" id="" cols="30" rows="10" placeholder="Введите сообщение"></textarea><br>
	    <input name="sendForm" type="submit" value="Отправить форму!">
    </form>