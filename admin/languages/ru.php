<?php	
	
	//	Общее
	$yes = "Да";
	$no = "Нет";
	$cancel = "Омтена";
	$ok = "ОК";

	//	Ошибки 
	///////////////////////////////////////////////////////////////////

	//	Системные
	//	system_manager
	$noSettingName = "Не указано название параметра для получения значения";

	//	Авторизация
	$auth_error = "Ошибка авторизации";
	$auth_fatal_error = "Возникла серьезная ошибка с доступом к базе данных";
	$antispam_attention = "Вы сделали слишком много попыток неверной авторизации, вам нужно подождать " . ( Oxs::G("cfg")->Get("time_wait") ). " секунд";
	$auth_good = "Авторизация успешна";
	//////////////////////////////////////////////////////////////////
	
	//	Имитация прцоесса загрузки
	$loading = "Загрузка...";
	$loading1 = "Загрузка";
	$loading2 = "Загрузка.";
	$loading3 = "Загрузка..";
	$loading4 = "Загрузка...";

	//	Форма ввода
	$login = "Логин";
	$password = "Пароль";
	$enter_button = "Вход";
	$coockie_attention="Внимание! На этом сайте используються куки, включите их в противном случае корректная работа сайта не гарантируется";

	//	Мастер пароль
	$enterMasterPassword = "Введите мастер пароль";
	$enterMasterPasswordWrong = "Не верный мастер пароль";

	//	Блоки данных	
	///////////////////////////////////////////////////////////////
	$data_blocks_not_exist = "Блок данных \"".($this->GetParam(1))."\" не найден";
	$data_blocks_id_not_exist = "Блок данных с id = \"".($this->GetParam(1))."\" не найден";
	$data_blocks_field_not_found = "код поля \"". ($this->GetParam(1)) ."\" для блока данных не найден";
	$dataBlocksFieldError = "Критическая ошибка в коде файла полей: " . ($this->GetParam(1)) ;
	$noRecords = "Блок пуст или записей не найдено";
	$cantDeleteBlockItHaveChilds = "Среди выбранных блоков данных для удаления есть блок у которог оесть потомки, удаление не будет произведено, сначала удалите потомков";
	$NoSelectedRecord = "Вы не выбрано не одной записи";
	$GOOD_blocks_remove = "Выбранные блоки данных успешно удалены";
	$BAD_blocks_remove = "НЕ удалось удалить выбранные блоки данных";

	//	Поля
	$notFill = "Не заполнено поле \"".$this->GetParam(1) . "\"";
	$notInteger = "Поле \"".$this->GetParam(1) . "\" должно быть числом";
	$integerSoSmal = "Поле \"".$this->GetParam(1) . "\" не может быть отрицательным";
	$integerSoBig = "Поле \"".$this->GetParam(1) . "\" не может быть больше 1000";
	$cantCreateField = "Не смог создать поле в указанном блоке \"".$this->GetParam(1)."\", неизвестный тип поля:\"".$this->GetParam(2)."\" или оно пустое";
	$fieldAddGood = "Поле успешно доабвлено к блоку";
	$FieldDeleteGood = "Выбранные поля успешно удалены";
	$fieldNotExist = "Поле не найдено";
	$cantConvertFieldType = "Не удалось конвертировать тип поля" . "\"".$this->GetParam(1) . "\" (\"".$this->GetParam(2) . "\")"  ;
	$noFields = "для блока не добавлено не одного поля";
	$confirm_remove_field = "Будут удалены все записи данного поля, при этом корректной обработка не будет, удаляйте поля только если вы уверены что данные поля можно удалить безвредно для блока";
	$positionChangeErrorWrongBlocksNames = "Вы не можете перенести поле из одного блока в дргуой";

	//	tree поля
	$positionTreeChangeErrorWrongBlocksNames = "Вы не можете перенести кнопку из одного блока в дргуой";

	//	default
	$noSelectedToRemove = "Не выбрано не одной записи для удаления, выберите хотя бы одну запись";
	$noSelectedToChangeStatus = "Не выбрано не одной записи для измеения статуса, выберите хотя бы одну запись";
	$statusChangeGood = "Статус выбранных элементов успешно изменен";
	$blockHaveNoFields = "Блок не имеет полей";
	$areYouShureDelete = "Вы дейстивтельно хотите удалить выбранные элементы?";
	$noID = "Не передан id записи для редактирвоания";
	$defaultFixGood = "Запись успешно изменена";
	$defaultAddGood = "Запись успешно добавлена";
	$removeGood = "Записи успешно удалены";
	$DefaultpositionChangeGood = "Порядок записей изменен";	
	$CuteSelect = "Запись для вырезания выделена, тепрь укажите куда её нужно вставить";
	$CopySelect = "Запись для опирования выделена, тепрь укажите куда её нужно вставить";
	$COPY_CUT_SUCCESS = "Операция вырезания/копирования выполнена успешно";

	//	default tree
	$defaultTreeChangeParentGood = "Родитель успешно изменен";
	$defaultTreeChangeParentError = "Не удалось изменить родителя";
	$MultiselectPosition = "Нужно выбрать только один элемент";
	$MultiselectPositionOk = "Запись для перемещеняи выбрана: " . $this->GetParam(1);
	$TreeRecordSelected = "Запись выбрана";
	$removeGood = "Выбранные записи успешно удалены";

	//	blocks
	$noAccess = "Не верный уровень доступа (должно быть число от 0 до 1000)";
	$blockAlreadyExist = "Блок с системным именем ".($this->GetParam(1))." уже существует";
	$tableAlreadyExist = "Таблица с системным именем ".( Oxs::G("cfg")->Get("dbprefix") ).($this->GetParam(1))." уже существует";
	$wrongPID = "Ошибка в поле \"Блок родитель\"";
	$dataBlockAddedSuccess = "Блок данных успешно создан";
	$dataBlockUpdateSuccess = "Блок данных успешно изменен";
	$dataBlockRemovededSuccess = "Блок \"". ($this->GetParam(1)) ."\" удален успешно";
	$noEditRoot = "Нельзя редактировать root запись";
	$tableRenameGood = "Таблица успешно переименована";
	$tableRenameError = "Ошибка при переименовывании таблицы";
	$positionChangeGood = "Порядок записей изменен";
	$positionChangeErrorCurrentIdAschangeId = "Позиция перемещаемой записи такая же как у записи к которой необходимо переместить";
	$positionChangeErrorСhangeId = "Неверный id записи за котороую нужно переместить";
	$positionChangeErrorcurrentId = "Неверный id перемещаемой записи";
	$FieldsRenameGood = "Поля перенаправлены на новое системнео имя блока. Не забудьте ивнести изменения в кнопки";
	$FieldsRenameError = "Ошибка при перенаправлении полей на новое системное имя блока";

	//	Butons
	$wrongBID = "Ошибка в поле \"Блок\"";
	$buttonAlreadyExist = "Кнопка ".($this->GetParam(1))." с такими паарметрами  уже существует";
	$buttonRemovededSuccess = "Кнопка ".($this->GetParam(1))." удалена уcпешно";


	//	Фильтры
	///////////////////////////////////////////////////////////////

	//	boolean
	$noMode = "Не найден параметр mode";

	//	Data 
	$noM = "Не найден параметр m";

	//	default_value
	$noV = "Не найден параметр v";

	//	show_level
	$noField= "Не найден параметр field";

	//	max_lenght
	$soLongData = "Превышено количество символов в пооле \"".($this->GetParam(1))."\" (\"".($this->GetParam(2))."\")";

	//	unique_add_end
	$converTypeError = "unique_add_end: ошибка при конвертирвоании типа";
	$uniqueFailed = "Поле \"".($this->GetParam(1))."\" не уникально";

	//	блок setting
	$cfgNotWriteable = "Внимние!!! Файл cfg.php не доступен для записи";

	//	tag_selector
	$NEW_TAG_BIND = "Прикрепить";
	$no_tag_search_result = "Элментов удовлетворяющих поиску не найдено";
	$ALREADY_EXIST = "Такой элемент уже добавлен";

	//	docs
	$TAG_EMPTY = "Теги не указаны";

	//	file_manager
	$SELECT_FILE_TO_DOWNLOAD = "Нажмите на эту зону для выбора файла или перетащите сюда файлы";
	$DIR_IS_NOT_WRITABLE = "Файл не загружен, ошибка доступа или не верный путь";
	$MAX_UPLOAD_COUNT = "Превышено максимлаьное количество файлов (".$this->GetParam(1).")";
	$MAX_SIZE_FILE = "Превышен размер одного из файлов (".$this->GetParam(1).")";
	$DROP_CURSOR = "Отпустите курсор для начал загрузки файлов";	
	$SUCCESS_UPLOAD = "Файл успешно загружены";
	$FILE_DELETE_SUCCESS = "Файл успешно удален";
	$FILE_DELETE_FAIL = "Ошибка удаления файла";
	$DOCS_ADD = "Прикрепить документы";
	$WRONG_EXTENTION_FILE = "Запрещенное расширение файла ".$this->GetParam(1). " (".$this->GetParam(2).")";



	
