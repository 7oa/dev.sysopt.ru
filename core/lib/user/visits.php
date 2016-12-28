<?php

namespace Core\Main;

use Core\Main\DataManager,
    Core\Main\User,
    Core\Main\Soap;
	
	class Visits extends DataManager {

		// При создании экземпляра класса формируется переменная $this->data, содержащая в себе все
		// посещения сгрупированные по ID пользователей.
		function __construct($dfrom = false, $dto = false) {
			$connect = DataBase::getConnection();
			$res = $connect->query("SELECT * FROM `visits` WHERE `START` > '$dfrom' AND `START` < '$dto' ORDER BY `TIMESTAMP_X` DESC");
			$this->data = $res->fetchAll();
			$this->groupById($dto, $dfrom);
		}
		
		public static function getTable() {
			return "visits";
		}
		
		public static function getFieldMap() {
			return array(
				'ID' => array(
					'data_type' => 'integer',
					'primary' => true,
					'autocomplete' => true,
				),
				'TIMESTAMP_X' => array(
					'data_type' => 'datetime',
					'required' => true,
					'title' => 'Время изменения'
				),
				'USER_ID' => array(
					'data_type' => 'integer',
					'primary' => false,
					'autocomplete' => false,
				),
				'LOGIN' => array(
					'data_type' => 'string',
					'required' => true,
					'title' => 'Логин'
				),
				'ORGANIZATION' => array(
					'data_type' => 'string',
					'required' => true,
					'title' => 'Организация'
				),
				'START' => array(
					'data_type' => 'integer',
					'primary' => false,
					'autocomplete' => false
				),
				'SESSION_TIME' => array(
					'data_type' => 'integer',
					'primary' => false,
					'autocomplete' => false
				),
				'TYPE' => array(
					'data_type' => 'integer',
					'primary' => false,
					'autocomplete' => false
				)
			);
		}

		// Группировка выборки по ID пользователя.
		private function groupById($to, $from) {

			// Группируем по ID
			$data = array();
			for($i = 0; $i < count($this->data); $i++) {
				$row = $this->data[$i];
				$uid = $row['USER_ID'];

				if ($data[$uid] == false) {
					$data[$uid] = array();
						$data[$uid]['date'] = array();
						$data[$uid]['rows'] = array();
				}

				$time = date("d.m.Y", strtotime($row['TIMESTAMP_X']));

				unset($row['USER_ID']);
				$data[$uid]['date'][$time] = 1;
				$data[$uid]['rows'][] = $row;
			}

			// Генерируем массив данных пользователя.
			foreach($data as $key => $value) {

				$connect = DataBase::getConnection();

				$tmp = array();
				$all = $connect->query("SELECT * FROM `visits` WHERE `USER_ID` = '$key'")->fetchAll();
				$orders = $connect->query("SELECT * FROM `orders` WHERE `USER_ID` = '$key'")->fetchAll();

				// Группировка посещений по дням.
				$date = array();
					$date['all'] = array();
					$date['this'] = array();
				
				for ($i = 0; $i < count($all); $i++) {

					$row = $all[$i];
					$ID = $row['USER_ID'];
					$time = date("d.m.Y", strtotime($row['TIMESTAMP_X']));

					if (empty($date['all'][$time])) $date['all'][$time] = 0;
					$date['all'][$time] = $date['all'][$time] + 1;

					if ($data[$ID]['date'][$time] == true) {
						if (empty($date['this'][$time])) $date['this'][$time] = 0;
						$date['this'][$time] = $date['this'][$time] + 1;
					}

				}

				// Количество посещений всего.
				$tmp['all_visits'] = count($all);
				$tmp['all_days'] = count($date['all']);
				$tmp['all_orders'] = count($orders);

				$tmp['this_visits'] = count($value['rows']);
				$tmp['this_days'] = count($date['this']);
				$tmp['this_orders'] = 0;

				for ($i = 0; $i < count($orders); $i++) {

					$time = strtotime($orders[$i]['TIMESTAMP_X']);

					if ($time > $from && $time < $to) {
						$tmp['this_orders'] = $tmp['this_orders'] + 1;
					}

				}

				$data[$key]['info'] = $tmp;

			}
	
			$this->data = $data;

		}

		// Данный метод занимается выборкой всех активных посещений.
		// Если пользователь отсутствует более 15 минут, посещение считается закрытым.
		public static function checkVisits() {

			$connect = DataBase::getConnection();
			$all = $connect->query("SELECT * FROM `visits` WHERE `TYPE` = '1'");
			$all = $all->fetchAll();

			for($i = 0; $i < count($all); $i++) {

				$time = time();
				$row = $all[$i];
				$row_id = $row['ID'];
				$row_time = strtotime($row['TIMESTAMP_X']);

				$summ = $time - $row_time;
				if ($summ > 900) {
					$up = $connect->query("UPDATE `visits` SET `TYPE` = '0' WHERE `ID` = '$row_id'");
				}

			}

		}

		// Метод создания или обновления статистики пользователя.
		public static function addVisitStat($id) {

			Visits::checkVisits(); // Перебираем посещения.
			$USER = User::getById($id); // Пользователь.

			$time = time(); // Время.

			// Делаем выбору из базы данных. Ищем активное посещение.
			$connection = DataBase::getConnection();
			$res = $connection->query("SELECT * FROM `visits` WHERE `USER_ID` = '$id' AND `TYPE` = '1'");
			$res = $res->fetchRaw();

			// Если пользователь отсутствовал более 15 минут, то создаём новое посещение.
			// Иначе обновляем старое.
			if ($res == false) {
				$time = time();
				$params = array(
					"USER_ID" => $USER['ID'],
					"LOGIN" => $USER['LOGIN'],
					"ORGANIZATION" => $USER['ORGANIZATION'],
					"START" => $time,
					"TYPE" => "1"
				);
				$id = static::add($params);
			} else {
				
				// Формула, подсчитывающая время сессии пользователя.
				// (Время последней активности - Время старта сессии) + (Настоящее время - Время последней активности).
				// == Время сессии до обновления + Время сессии после обновления.
				// Так как TIMESTAMP пользователя обновляется при обновлении данных пользователя,
				// после последнего обновления страницы время тоже идёт и без формулы будут теряться секунды активности.
				$event_id = $res['ID'];
				$session_time = (strtotime($res['TIMESTAMP_X']) - $res['START']) + ($time - strtotime($res['TIMESTAMP_X']));
				$up = $connection->query("UPDATE `visits` SET `SESSION_TIME` = '$session_time' WHERE `ID` = '$event_id'");
			}
		}

		// Метод для выборки посещений определённого пользователя по его ID
		public function getById($id) {
			if (isset($this->data[$id])) return $this->data[$id];
			else return false;
		}
		
		public static function add($data) {
			return parent::add($data);
		}
		
	}

?>