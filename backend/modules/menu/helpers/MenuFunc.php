<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 27.09.2015
 * Time: 3:31
 */

namespace app\modules\menu\helpers;


class MenuFunc {

	public function menu_to_db($items){
		$id = 0;
		$tree = array();
		foreach ($items as &$node) {
			if ($node['children']) {
				$this->menu_to_db($node['children']);
				$tree[$node['id']]['parent'] = &$node['id'];
			}
				$tree[$node['id']]['id'] = &$node['id'];
			$id++;
		}
		return $tree;
	}


	public function mapTree($data) {
		$tree = array();
		foreach ($data as $id=>&$node) {
			if (!$node['parent']) {
				$tree[$id] = &$node;
			}
			else {
				$data[$node['parent']]['children'][$id] = &$node;
			}
		}
		return $tree;
	}

}