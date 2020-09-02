<?php

namespace App\Controllers;

class Home extends \App\Controller {
	public function index() {
		$o_task_model = new \App\Models\Task();

		$a_sort_rules = [
			's_sort_field',
			's_sort_dir'
		];

		foreach ( $a_sort_rules as $s_sort_rule ) {
			$this->$s_sort_rule = $this->getSession()->$s_sort_rule;
		}

		$this->a_form_data = $this->getSession()->a_form_data;

		$this->a_tasks = $o_task_model->getItems();
		$this->a_pagination = $o_task_model->a_pagination;

		return $this->render( 'Home/Index' );
	}

	public function htmlSortLink( $fs_field, $fs_title ) {
		$s_html = '<a href="/task/sort?s_field=' . $fs_field . '">' . $fs_title;

		if ( $this->s_sort_field == $fs_field ) {
			if ( $this->s_sort_dir == 'ASC' ) {
				$s_icon = 'sort-ascending';
			} else {
				$s_icon = 'sort-descending';
			}

			$s_html .= ' <span class="oi oi-' . $s_icon . '"></span>';
		}

		$s_html .= '</a>';

		return $s_html;
	}

	public function htmlPagination() {
		if ( empty ( $this->a_pagination ) ) {
			return '';
		}

		$s_html = '<nav>
	<ul class="pagination">';

		$i_current = $this->a_pagination[ 'i_current' ];
		$i_total = $this->a_pagination[ 'i_pages' ];

		if ( $i_current != 1 ) {
			$s_html .= '
			<li class="page-item">
				<a class="page-link" href="/?page=' . ( $i_current - 1 ) . '" tabindex="-1">Prev</a>
			</li>';
		} else {
			$s_html .= '
			<li class="page-item disabled">
				<a class="page-link" href="#" tabindex="-1">Prev</a>
			</li>';
		}

		for ( $i = 1; $i <= $i_total; $i++ ) {
			$s_class = '';
			$s_link = '/?page=' . $i;
			if ( $i == $i_current ) {
				$s_class = ' active';
			}

			$s_html .= '<li class="page-item' . $s_class . '"><a class="page-link" href="' . $s_link . '"> ' . $i . ' </a></li>';
		}

		if ( $i_current != $i_total ) {
			$s_html .= '
			<li class="page-item">
				<a class="page-link" href="/?page=' . ( $i_current + 1 ) . '" tabindex="1">Next</a>
			</li>';
		} else {
			$s_html .= '
			<li class="page-item disabled">
				<a class="page-link" href="#" tabindex="+1">Next</a>
			</li>';
		}

		$s_html .= '	
  	</ul>
</nav>';

		return $s_html;
	}
}