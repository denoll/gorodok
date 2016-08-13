<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 13.08.2016
 * Time: 17:34
 */

namespace common\widgets\menu;

use common\models\Menu;

/**
 * Class Core
 * @package common\widgets\menu
 * @property Menu $data
 */
class Core
{

	protected $data;

	/**
	 * Core constructor.
	 * @param $data Menu
	 */
	public function __construct($data)
	{
		if ( empty($data) ) return null;
		$this->data = $data;
		return $this->buildTree($data);
	}

	public function buildTree($data)
	{
		$tree = [ ];
		if ( empty($data) ) return null;
		foreach ( $data as $id => &$node ) {
			if ( !$node[ 'parent' ] ) {
				$tree[ $id ] = &$node;
			} else {
				$data[ $node[ 'parent' ] ][ 'children' ][ $id ] = &$node;
			}
		}
		return $tree;
	}

}
