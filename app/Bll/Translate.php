<?php

namespace App\Bll;



class Translate
{

	private $items, $data, $lang_id;
	private 	$data_after = [];

	/**
	 *
	 * @var $items  array of master table
	 */
	public function __construct($items, $data, $lang_id)
	{
		$this->items = $items;
		$this->data = $data;
		$this->lang_id = $lang_id;
	}
	//feature_id
	private function formatData($key = "")
	{
		//dd($this->data);
		$lang_id = $this->lang_id;
		array_map(function ($elem) use ($key, $lang_id) {
			//dd($elem[$key],$elem["lang_id"]);
			$this->data_after[$elem[$key]][$elem["lang_id"]] = $elem;
		}, $this->data);
	}
	public function getData($key, $extra = [])
	{
		$this->formatData($key);
		$result = [];
		array_map(function ($elem) use (&$result, $extra) {
			$key = $elem["id"];
			if (!array_key_exists($key, $result)) {
				//dd( $this->data_after,$key);
				if (array_key_exists($key, $this->data_after))
					$find = $this->data_after[$key];
				else
					$data_lang = false;
				if (isset($find)) {
					if (isset($this->data_after[$key][$this->lang_id]))
						$data_lang = ($this->data_after[$key][$this->lang_id]);
				}

				if (!isset($data_lang) ) {
					$data_lang = array_first( $this->data_after[$key]);
				}
				if (is_array($extra)) {
					foreach ($extra as $col) {
						$elem[$col] = ($data_lang == false) ? "" : $data_lang[$col];
					}
				}
				// $elem["title"] = $data_lang["title"];
				// $elem["type"] =  $data_lang["type"];

				$result[$key] =  json_decode(json_encode($elem));
			}
		}, $this->items);
		return $result;
	}
}
