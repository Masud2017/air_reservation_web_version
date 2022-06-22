<?php
	namespace Util;

	class VariableBucket {
		private static $instance;
		private $variableMap = array("default"=> "default data");

		private function __construct() {} // making the constructor private so that it can't be instantiate using regular way

		public static function getInstance() {
			if (!isset(self::$instance)) {
				self::$instance = new VariableBucket();

				return self::$instance;
			}
			return self::$instance;
			
		}

		public function addVariable($variableName,$variableValue) {
			$this->variableMap[$variableName] = $variableValue;
		}

		public function getVariableMap() {
			return $this->variableMap;
		}
	}
?>