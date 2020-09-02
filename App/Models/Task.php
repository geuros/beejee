<?php

namespace App\Models;

class Task extends \App\Model {
	public $s_sort_dir = 'ASC';

	public $s_sort_field = 'i_id';

	public $i_offset = 0;

	public $i_limit = 3;

	public $a_pagination = [];

	public function getSort() {
		$a_sort_rules = [
			's_sort_field',
			's_sort_dir'
		];

		foreach ( $a_sort_rules as $s_sort_rule ) {
			$s_value = $this->getSession()->$s_sort_rule;
			if ( empty( $s_value ) == false ) {
				$this->$s_sort_rule = $s_value;
			}
		}
	}

	public function getLimit() {
		if (
			empty( $_GET[ 'page' ] )
			or
			$_GET[ 'page' ] == 1
		) {
			return;
		}

		$this->i_offset = ( $_GET[ 'page' ] - 1 ) * $this->i_limit;
	}

	public function getItems() {
		$o_db = \App::$o_db;

		$this->getSort();
		$this->getLimit();
		$this->generatePagination();

		$s_query = 'SELECT *' .
			' FROM ?n';

		$s_query .= $o_db->parse( ' ORDER BY ?n ' . $this->s_sort_dir, $this->s_sort_field );

		$s_query .= $o_db->parse( ' LIMIT ?i, ?i', $this->i_offset, $this->i_limit );

		return $o_db->getAll( $s_query, 'tasks' );
	}

	public function generatePagination() {
		$o_db = \App::$o_db;

		$s_query = 'SELECT COUNT(*)' .
			' FROM ?n';

		$i_total = $o_db->getOne( $s_query, 'tasks' );

		if ( $i_total > $this->i_limit ) {
			if ( empty( $_GET[ 'page' ] ) ) {
				$i_current = 1;
			} else {
				$i_current = ( int ) $_GET[ 'page' ];
			}

			$this->a_pagination = [
				'i_current' => $i_current,
				'i_pages' => ( int ) ceil( $i_total / $this->i_limit )
			];
		}
	}

	public function store( $fa_data ) {
		$s_query = 'INSERT INTO ?n SET ?u';

		\App::$o_db->query( $s_query, 'tasks', $fa_data );

		$this->getSession()->a_messages = [ [ 'success', 'Task added successful.' ] ];
	}

	public function get( $fi_id ) {
		$o_db = \App::$o_db;

		$s_query = 'SELECT *' .
			' FROM ?n' .
			' WHERE ?n = ?i';

		return $o_db->getRow( $s_query, 'tasks', 'i_id', $fi_id );
	}

	public function save( $fa_data ) {
		$o_db = \App::$o_db;

		$i_id = $fa_data[ 'i_id' ];

		unset( $fa_data[ 'i_id' ], $fa_data[ 's_task' ] );

		$s_query = 'UPDATE ?n' .
			' SET ?u' .
			' WHERE ?n = ?i';

		$o_db->query( $s_query, 'tasks', $fa_data, 'i_id', $i_id );

		$this->getSession()->a_messages = [ [ 'success', 'Task edited successful.' ] ];
	}
}